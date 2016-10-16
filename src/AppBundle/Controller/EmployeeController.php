<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use AppBundle\Form\CreateEmployeeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * @Route("/employees")
     **/
    public function indexAction()
    {
        return new Response("All employees");
    }

    /**
     * @Route("/employees/create")
     * @Method("POST")
     **/
    public function createEmployeeAction(Request $request)
    {
//        $form = $this->createForm(CreateEmployeeForm::class);

        $employee = new Employee();
        $employee->setEmail($request->get("email"));
        $employee->setFirstName($request->get("fName"));
        $employee->setLastName($request->get("lName"));
        $employee->setGender($request->get("gender"));
        $employee->setPicture($request->get("picture"));
        $employee->setPlainPassword($request->get('plainPassword'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($employee);
        $em->flush();
        return $this->json(['res' => "Created" . $employee->getFirstName()]);
    }

    /**
     * @Route("/employees/{id}")
     * @Method("GET")
     **/
    public function showEmployeeAction($id)
    {
        $employee = $this->getDoctrine()->getRepository("AppBundle:Employee")->find($id);
        $serializer = $this->get('jms_serializer');
        $jsonData = $serializer->serialize($employee,'json');
        return new Response($jsonData,200,['content-type'=>'text/json']);
    }

    /**
     * @Route("/employees/{id}")
     * @Method({"POST","PUT"})
     **/
    public function updateEmployeeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var $product Employee
         **/
        $employee = $em->getRepository("AppBundle:Employee")->find($id);
        if (!$product) {
            throw $this->createNotFoundException("There is no employee with id: " . $id);
        }
        $employee->setPicture("Working");
        $em->flush();
        return new Response("Updated" . $id);
    }

    /**
     * @Route("/employees/{id}")
     * @Method("DELETE")
     **/
    public function deleteEmployeeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var $employee Employee
         **/
        $employee = $this->getDoctrine()->getRepository("AppBundle:Employee")->find($id);
        $em->remove($employee);
        $em->flush();

        return new Response("deleted" . $employee->getFirstName());
    }
}
