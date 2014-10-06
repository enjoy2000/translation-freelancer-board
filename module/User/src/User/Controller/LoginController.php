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
use User\Entity\User;
use Hybridauth\Hybridauth;
use Hybridauth\Endpoint;

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
        $config = $this->getServiceLocator()->get('Config');
        if($provider = $this->getRequest()->getQuery('provider')){
            try{
                // create an instance for Hybridauth with the configuration file path as parameter
                $hybridauth = new Hybridauth($config['hybrid_auth']);

                // try to authenticate the user with twitter,
                // user will be redirected to Twitter for authentication,
                // if he already did, then Hybridauth will ignore this step and return an instance of the adapter
                $auth = $hybridauth->authenticate($provider);

                // get the user profile
                $profile = $auth->getUserProfile();


                // Create new user by social profile
                $translator = $this->getTranslator();
                $entityManager = $this->getEntityManager();
                $user = $entityManager->getRepository('User\Entity\User')->findOneBy(
                    array('email'=>$profile->getEmail()));
                if($user){
                    $auth->logout();
                    $user->authenticate();
                    $this->redirect()->toUrl('/user/dashboard');
                }else{
                    // TODO: redirect to register social action
                    $this->flashMessenger()->addInfoMessage(
                        $translator->translate('You have to register by your social account first.'));
                    $this->redirect()->toUrl('/user/register');
                }
            }
            catch( Exception $e ){
                // Display the recived error,
                // to know more please refer to Exceptions handling section on the userguide
                $translator = $this->getTranslator();
                $this->flashMessenger()->addErrorMessage($translator->translate('Cannot login by social account.'));
            }
        }
        if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done']))
        {
            (new Endpoint())->process();

        }
        return new ViewModel();
    }
}