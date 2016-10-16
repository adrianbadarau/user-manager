<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use AppBundle\Form\CreateEmployeeForm;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * @Route("/api/employees")
     **/
    public function indexAction(Request $request)
    {
        /**
         * @var $query QueryBuilder
         **/
        $query = $this->getDoctrine()->getRepository('AppBundle:Employee')->createQueryBuilder('e');
        if($fName = $request->query->get('FirstName')){
            $query->where('e.firstName = :fName');
            $query->setParameter('fName',$fName);
        }
        if ($lName = $request->query->get('LastName')){
            $query->where('e.lastName = :lName');
            $query->setParameter('lName', $lName);
        }
        if($superId = $request->query->getInt('Supervisor')){
            $query->where('e.supervisor_id = :superId');
            $query->setParameter('superId',$superId);
        }
        if($filters = $request->query->get('Duties')){
            $duties = explode(',',$filters);
            $query->innerJoin('e.duties','d','WITH','d.id IN (:duties)');
            $query->setParameter('duties', $duties);
            $query->groupBy('e.id');
        }
        $results = $query->getQuery()->getResult();
        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($results, 'json');
        return new Response($data, Response::HTTP_OK,['content-type'=>'text/json']);
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
        return new Response(json_encode(['success' => "Created".$employee->getEmail()]),200,['content-type'=>'text/json']);
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
