<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * Este archivo pertenece a la aplicación de prueba Cupon.
 * El código fuente de la aplicación incluye un archivo llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OfertaController extends Controller
{
    /**
     * Muestra la página de detalle de la oferta indicada.
     *
     * @Route("/{ciudad}/ofertas/{slug}", name="oferta")
     * @Cache(smaxage="60")
     *
     * @param string $ciudad El slug de la ciudad a la que pertenece la oferta
     * @param string $slug   El slug de la oferta (es único en cada ciudad)
     */
    public function ofertaAction($ciudad, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $oferta = $em->getRepository('AppBundle:Oferta')->findOferta($ciudad, $slug);
        $cercanas = $em->getRepository('AppBundle:Oferta')->findCercanas($ciudad);

        if (!$oferta) {
            throw $this->createNotFoundException('No se ha encontrado la oferta solicitada');
        }

        return $this->render('oferta/detalle.html.twig', array(
            'cercanas' => $cercanas,
            'oferta' => $oferta,
        ));
    }
}
