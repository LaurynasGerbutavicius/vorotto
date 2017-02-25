<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @return Response
     */
    public function searchAction(Request $request)
    {
        $q = $request->get('q');
        $em = $this->getDoctrine()->getManager();
        if ($q) {
            $tasks = $em->getRepository('AppBundle:Task')->findBy(['title' => $q]);
        } else {
            $tasks = $em->getRepository('AppBundle:Task')->findAll();
        }
        return $this->render('task/index.html.twig', array(
            'tasks' => $tasks,
            'q' => $q
        ));
    }
}