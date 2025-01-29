<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CommentRepository;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Rating;
use App\Tools\FileTools;
use App\Repository\TypeRepository;
use App\Repository\AuthorRepository;
use App\Repository\RatingRepository;


class BookController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'show':
                        $this->show();
                        break;
                    case 'add':
                        $this->add();
                        break;
                    case 'edit':
                        $this->edit();
                        break;
                    case 'delete':
                        $this->delete();
                        break;
                    case 'list':
                        $this->list();
                        break;
                    default:
                        throw new \Exception("This action does not exist : " . $_GET['action']);
                        break;
                }
            } else {
                throw new \Exception("Aucune action détectée");
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }
    /*
    Exemple d'appel depuis l'url
        ?controller=book&action=show&id=1
    */
    protected function show()
    {
        $errors = [];

        try {
            if (isset($_GET['id'])) {

                $id = (int)$_GET['id'];
                // Charger le livre par un appel au repository findOneById
                $bookRepository = new BookRepository();
                $book = $bookRepository->findOneById($id);

                if ($book) {
                    //@todo create a new instance of CommentRepository
                    //@todo create a new instance of comment setting the book id and the user id from the connected user (User::getCurrentUserId())
                    // $comment


                    if (isset($_POST['saveComment'])) {
                        if (!User::isLogged()) {
                            throw new \Exception("Accès refusé");
                        }
                        //@todo call the hydrate method of the comment object passing the $_POST array

                        //@todo verify that the comment is valid calling the method validate

                        
                        if (empty($errors)) {
                            // @todo if no error call the persist method on the commentRepository object passing $comment
                            
                        }
                    }

                    // @todo get exisitng comments and store them in $comments

                    //@todo replace teps by step the values of the array 
                    $this->render('book/show', [
                        'book' => $book,
                        'comments' => '',
                        'newComment' => '',
                        'rating' => '',
                        'averageRate' => '',
                        'errors' => '',
                    ]);
                } else {
                    $this->render('errors/default', [
                        'error' => 'Book not found'
                    ]);
                }
            } else {
                throw new \Exception("id is missing url params");
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function add()
    {
        $this->add_edit();
    }

    protected function edit()
    {
        try {
            if (isset($_GET['id'])) {
                $this->add_edit((int)$_GET['id']);
            } else {
                throw new \Exception("id is missing url params");
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function add_edit($id = null)
    {

        try {
            // This action is for admin only
            if (!User::isLogged() || !User::isAdmin()) {
                throw new \Exception("Access denied");
            }
            $bookRepository = new BookRepository();
            $errors = [];
            // if there is no id, we are in creation mode
            if (is_null($id)) {
                $book = new Book();
            } else {
                // if we have an id, we want to get the book
                $book = $bookRepository->findOneById($id);
                if (!$book) {
                    throw new \Exception("The book does not exist");
                }
            }

            // @todo Get types
            

            // @todo get authors
        

            if (isset($_POST['saveBook'])) {
                //@todo Send $_POST to the hydrate method of the $book object
                

                //@todo call the validate method on the $book object to get errors (ex: empty title)
                

                // If no error, we can manage the file upload
                if (empty($errors)) {
                    $fileErrors = [];
                    if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] !== '') {
                        //@todo call the static methoduploadImage from FileTools and store the result in $res
                        
                        if (empty($res['errors'])) {
                            //@todo Uncomment the line bellow
                            //$book->setImage($res['fileName']);
                        } else {
                            //@todo Uncomment the line bellow
                            //$fileErrors = $res['errors'];
                        }
                    }
                    if (empty($fileErrors)) {
                        // @todo if no error, we call persist from bookRepository passing $book


                        // @todo We redirect to to book page using header location
                        
                    } else {
                        $errors = array_merge($errors, $fileErrors);
                    }
                }
            }

            $this->render('book/add_edit', [
                'book' => $book,
                'types' => '',
                'authors' => '',
                'pageTitle' => 'Add a book',
                'errors' => ''
            ]);
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function list()
    {

        $bookRepository = new BookRepository;
        if (isset($_GET['page'])) {
            $page = (int)$_GET['page'];
        } else {
            $page = 1;
        }

        //@todo  start by getting all books (pagination will be managed later)

        //@todo for pagination we nned to know the total books

        //@todo for pagination we need to know the number of pages


        $this->render('book/list', [
            'books' => '',
            'totalPages' => '',
            'page' => '',
        ]);
    }


    protected function delete()
    {
        try {
            // For admin only
            if (!User::isLogged() || !User::isAdmin()) {
                throw new \Exception("Access denied");
            }

            if (!isset($_GET['id'])) {
                throw new \Exception("id is missing url params");
            }
            $bookRepository = new BookRepository();

            $id = (int)$_GET['id'];

            $book = $bookRepository->findOneById($id);

            if (!$book) {
                throw new \Exception("Book does not exist");
            }
            if ($bookRepository->removeById($id)) {
                // Redirect to list
                header('location: index.php?controller=book&action=list&alert=delete_confirm');
            } else {
                throw new \Exception("Une erreur est survenue l'ors de la suppression");
            }

        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
