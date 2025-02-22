<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    #[Route('/import', name: 'import_data')]
    public function import(EntityManagerInterface $entityManager): Response
    {
        // Загружаем данные
        $postData = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        $commentData = file_get_contents('https://jsonplaceholder.typicode.com/comments');

        $posts = json_decode($postData, true);
        $comments = json_decode($commentData, true);

        // Удаляем старые данные
        $entityManager->createQuery('DELETE FROM App\Entity\Comment')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Post')->execute();
        $entityManager->flush();

        // Загружаем записи
        $postMap = [];
        foreach ($posts as $post) {
            $newPost = new Post();
            $newPost->setTitle($post['title']);
            $newPost->setBody($post['body']);
            $entityManager->persist($newPost);
            $postMap[$post['id']] = $newPost;
        }
        $entityManager->flush();

        // Загружаем комментарии
        $commentCount = 0;
        foreach ($comments as $comment) {
            if (isset($postMap[$comment['postId']])) {
                $newComment = new Comment();
                $newComment->setBody($comment['body']);
                $newComment->setPost($postMap[$comment['postId']]);
                $entityManager->persist($newComment);
                $commentCount++;
            }
        }
        
        $entityManager->flush();

        return new Response("Загружено " . count($posts) . " записей и $commentCount комментариев.");
    }
}
