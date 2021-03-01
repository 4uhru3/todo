<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Rest\Route("/api/task")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
final class TaskController extends AbstractController
{
	/** @var EntityManagerInterface */
	private $em;

	/** @var SerializerInterface */
	private $serializer;

	/** @var TaskRepository */
	private $taskRepository;

	/** @var array */
	private $errors = [];

	/**
	 * TaskController constructor.
	 * @param TaskRepository $taskRepository
	 * @param EntityManagerInterface $em
	 * @param SerializerInterface $serializer
	 */
	public function __construct(
		TaskRepository $taskRepository,
		EntityManagerInterface $em,
		SerializerInterface $serializer
	)
	{
		$this->em = $em;
		$this->taskRepository = $taskRepository;
		$this->serializer = $serializer;
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 * @Rest\Post("/create", name="create_task")
	 */
	public function createAction(Request $request): JsonResponse
	{
		$success = false;
		$data = [];
		$user = $this->getUser();
		$task = new Task();
		$task->setUser($user);

		$form = $this->createForm(TaskType::class, $task);

		if ($this->processTaskForm($form, $request)) {
			$success = true;
			$data = $form->getData();
		}

		return $this->apiResponseFormat($success, $data);
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 * @Rest\Post("/update/{id}", name="update_task")
	 */
	public function updateAction(Request $request): JsonResponse
	{
		$success = false;
		$data = [];
		$id = $request->get('id');

		$task = $this->fetchTask($id);
		$form = $this->createForm(TaskType::class, $task);

		if ($this->processTaskForm($form, $request)) {
			$success = true;
			$data = $form->getData();
		}

		return $this->apiResponseFormat($success, $data);
	}

	/**
	 * @Rest\Get("/list", name="find_all_tasks")
	 * @param $request
	 * @return JsonResponse
	 */
	public function listAction(Request $request): JsonResponse
	{
		$completed = $request->get('completed');

		if (!is_null($completed)) {
			$completed = (int)$completed;
		}

		$tasks = $this->taskRepository->getListByUserByCompleted($this->getUser(),$completed);

		return $this->apiResponseFormat(true, $tasks);
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 * @Rest\Post("/complete/{id}", name="complete_task")
	 */
	public function completeAction(Request $request): JsonResponse
	{
		$success = true;
		$id = $request->get('id');

		$task = $this->fetchTask($id);
		if (!$task->isCompleted()) {
			$task->setCompleted(true);
			$this->em->persist($task);
			$this->em->flush();
		} else {
			$this->errors[] = [
				"Task is already completed"
			];
			$success = false;
		}

		return $this->apiResponseFormat($success, $task);
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 * @Rest\Post("/delete/{id}", name="delete_task")
	 */
	public function deleteAction(Request $request): Response
	{
		$success = true;
		$id = $request->get('id');

		$task = $this->fetchTask($id);
		if ($task->isCompleted()) {
			$this->em->remove($task);
			$this->em->flush();
		} else {
			$this->errors[] = [
				"Can't delete not completed task"
			];
			$success = false;
		}

		return $this->apiResponseFormat($success, $task);
	}

    /**
     * @param string $id
     * @return Task
     */
	private function fetchTask(string $id): Object
	{
		if (!$this->validateUuid($id)) {
			throw new BadRequestHttpException('Not valid uuid');
		}

		$task = $this->taskRepository->finByUser($id, $this->getUser());

		if (empty($task)) {
			throw new NotFoundHttpException("Task with uuid: $id not found");
		}

		return $task;
	}

	/**
	 * @param FormInterface $form
	 * @param Request $request
	 * @return bool
	 */
	private function processTaskForm(FormInterface $form, Request $request): bool
	{
		$params = json_decode($request->getContent(), true);

		if (empty($params)) {
			throw new BadRequestHttpException('Request params is empty');
		}

		$form->submit($params, true);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->em->persist($form->getData());
			$this->em->flush();
		} else {
			foreach ($form->getErrors(true) as $error) {
				$this->errors[] = $error->getMessage();
			}
			return false;
		}

		return true;
	}

	/**
	 * @param mixed $data
	 * @param bool $success
	 * @return JsonResponse
	 */
	private function apiResponseFormat(bool $success, $data = null): JsonResponse
	{
		$responseFormat = [
			'success' => $success,
			'errors' => $this->errors,
		];

		if (!is_null($data)) {
			$responseFormat['data'] = $data;
		}

		$response = $this->serializer->serialize($responseFormat, JsonEncoder::FORMAT);

		return new JsonResponse($response, Response::HTTP_OK, [], true);
	}

	/**
	 * @param string $id
	 * @return bool
	 */
	private function validateUuid(string $id): bool
	{
		return Uuid::isValid($id);
	}

}
