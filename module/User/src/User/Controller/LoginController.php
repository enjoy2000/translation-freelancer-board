<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/19/14
 * Time: 9:37 AM
 */

namespace User\Controller;

use Zend\View\Model\ViewModel;

use Application\Controller\AbstractActionController;
use User\Form\LoginForm;
use Hybridauth\Hybridauth;

class LoginController extends AbstractActionController
{

    /**
     * @return LoginForm
     */
    protected function getForm(){
        $form = new LoginForm();
        return $form;
    }

    public function indexAction(){
        $form = $this->getForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                if($form->validate($this)){
                    return $this->redirect()->toUrl('/admin/dashboard');
                }
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function socialAction(){
        $request = $this->getRequest();
        $provider = $request->getQuery('provider');
        //var_dump($provider);die;
        $config = $this->getServiceLocator()->get('Config');
        $config = $config['OrgHeiglHybridAuth'];
        $ha = new Hybridauth($config['hybrid_auth']);
        $t = $ha->authenticate('Facebook');
        if($t->isUserConnected()){
            $profile = $t->getUserProfile();
            var_dump($profile);die;
        }else{
            die('nc');
        }
    }

    public function testAction(){
        $config = $this->getServiceLocator()->get('Config');
        $config = $config['OrgHeiglHybridAuth'];
        $hybridAuth = new Hybridauth($config['hybrid_auth']);

        // The name of the session-container can be changed in the config file!
        $container = new \Zend\Session\Container('orgheiglhybridauth');
        if (! $container->offsetExists('authenticated')) {
            echo 'No user logged in';
        }
        /** @var \OrgHeiglHybridAuth\UserInterface $user */
        $user = $container->offsetGet('user');
        echo $user->getName(); // The name of the logged in user
        echo $user->getUID();  // The internal UID of the used service
        echo $user->getMail(); // The mail-address the service provides
        echo $user->getLanguage(); // The language the service provides for the user
        $service = $container->offsetGet('backend');
        echo $service->id; // Should print out the Name of the service provider.
    }
}