<?php

namespace App\Controller;

class Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['controller'])) {
                switch ($_GET['controller']) {
                    case 'page':
                        //charger controleur page
                        $controller = new PageController();
                        $controller->route();
                        break;
                    case 'book':
                        //charger controleur book
                        $controller = new BookController();
                        $controller->route();
                        break;
                    case 'auth':
                        //charger controleur auth
                        $controller = new AuthController();
                        $controller->route();
                        break;
                    case 'user':
                        $controller = new UserController();
                        $controller->route();
                        break;
                    default:
                        throw new \Exception("Controller does not exist");
                        break;
                }
            } else {
                $controller = new PageController();
                $controller->home();
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function render(string $path, array $params = []): void
    {
        $filePath = _ROOTPATH_ . '/templates/' . $path . '.php';

        try {
            if (!file_exists($filePath)) {
                throw new \Exception("Fichier non trouvé : " . $filePath);
            } else {
                extract($params);
                require_once $filePath;
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
