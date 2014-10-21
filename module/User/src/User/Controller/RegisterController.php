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
use User\Form\UserForm;
use User\Entity\User;
use Hybridauth\Hybridauth;

class RegisterController extends AbstractActionController
{

    public function indexAction(){
        return new ViewModel();
    }

    public function employerAction(){
        return $this->process('employer');
    }

    public function freelancerAction(){
        return $this->process('freelancer');
    }

    protected function getForm(){
        $form = new UserForm();
        $user = new User();
        $form->bind($user);
        return $form;
    }

    public function process($userType){
        $form = $this->getForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid() && $request->getPost('agree') == 1){
                $translator = $this->getTranslator();
                $entityManager = $this->getEntityManager();
                $userExist = $entityManager
                    ->getRepository('User\Entity\User')
                    ->findOneBy(array(
                        'email'=>$request->getPost('email')
                    ));
                if($userExist){
                    $this->flashMessenger()->addErrorMessage($translator->translate('This email has been registered already.'));
                } else {
                    $form->save($this, $userType);
                    return $this->redirect()->toUrl('/user/register/confirm?email=' . $request->getPost('email'));
                }

            }
        }
        return new ViewModel(array(
            "u" => $userType,
            "form"=> $form,
            )
        );
    }

    public function confirmAction(){
        $request = $this->getRequest();
        $token = $request->getQuery('token');
        $email = $request->getQuery('email');

        if($token){
            $entityManager = $this->getEntityManager();
            /**
             * @var $user \User\Entity\User
             */
            $user = $entityManager->getRepository('User\Entity\User')
                                    ->findOneBy(array(
                                        'token'=>$token)
                                    );

            if(!$user){
                $translator = $this->getTranslator();
                $this->flashMessenger()->addErrorMessage($translator->translate('Your token has expired.'));
                return $this->redirect()->toUrl('/user/login');
            }

            if($user && $user->activate($token, $entityManager)){
                $user->authenticate();
                $user->sendWelcomeEmail($this);
                return $this->redirect()->toUrl("/admin/dashboard");
            }
        }

        return new ViewModel(array(
            'email' => $email
            )
        );
    }

    public function socialAction(){
        $request = $this->getRequest();
        $userType = $request->getQuery('type');
        $provider = $request->getQuery('provider');
        $config = $this->getServiceLocator()->get('Config');
        if($provider){
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
                }else{
                    $auth->logout();
                    $newUser = new User();
                    $newUser->createUserBySocialProfile($this, $profile, $userType);
                }
                $this->redirect()->toUrl('/user/dashboard');
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