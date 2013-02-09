<?php 
namespace Kuba\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Kuba\UserBundle\Form\Type\RegistrationType;
use Kuba\UserBundle\Form\Model\Registration;
use Kuba\UserBundle\Entity\User;

class RegistrationController extends Controller
{
    public function registrationAction(Request $request){
        
        $form = $this->createForm(new RegistrationType());
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->createUser($data);
                return $this->redirect($this->generateUrl('kuba_user_registration_success'));
            }
        }
        
        $options = array();
        $options['form'] = $form->createView();
        return $this->render('KubaUserBundle:Registration:registration.html.twig', $options);
    }
    
    public function successAction(){
        $options = array();
        return $this->render('KubaUserBundle:Registration:success.html.twig', $options);
    }
    
    protected function createUser(Registration $data){
        $newUser = new User();
        
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($newUser);
        $password = $encoder->encodePassword($data->password, $newUser->getSalt());
        $newUser->setPassword($password);
        $newUser->setUsername($data->username);
        $newUser->setEmail($data->email);
        
        $sendValidation = true;
        if($sendValidation){
            $token = md5(uniqid(null, true));
            $encodedToken = $encoder->encodePassword($token, $newUser->getSalt());
            $newUser->setToken($encodedToken);
            //TODO: Send Token
        }
        
        //TODO: Send Validation Email. For now, enable user
        $newUser->enable();
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($newUser);
        $em->flush();
    }
}