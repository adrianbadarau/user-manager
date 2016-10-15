<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $employee = new Employee();
        $employee->setEmail($request->get("email"));
        $employee->setFirstName($request->get("fName"));
        $employee->setLastName($request->get("lName"));
        $employee->setGender($request->get("gender"));
        $employee->setPicture($request->get("picture"));
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
