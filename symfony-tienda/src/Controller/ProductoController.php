<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Tienda;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProductoController extends AbstractController{

    private $productos = [
        1 => ["producto" => "portatil","modelo" => "Acer Aspire 3", "caracteristicas" => "procesador: intel i3 RAM: 4GB", "precio" => "434€"],
        2 => ["producto" => "portatil","modelo" => "Realme Book", "caracteristicas" => "procesador: i5 RAM: 8GB", "precio" => "939€"],
        3 => ["producto" => "móvil", "modelo" => "realme GT", "caracteristicas" => "memoria: 128GB RAM: 6GB", "precio" => "279€"],
        4 => ["producto" => "televisor", "modelo" => "Xiaomi P1E", "caracteristicas" => "resolucion 43', calidad: 4K", "precio" => "259€"]
    ];

    /**
    * @Route("/producto/nuevo", name="nuevo_producto")
    */

    public function nuevo(ManagerRegistry $doctrine, Request $request) {
        $producto = new Producto();

        $formulario = $this->createFormBuilder($producto)
        ->add('producto', TextType::class)
        ->add('modelo', TextType::class)
        ->add('caracteristicas', TextType::class)
        ->add('precio', TextType::class)
        ->add('tienda', EntityType::class , array('class' => Tienda::class, 'choice_label' => 'nombre',))
        ->add('save', SubmitType::class, array('label' => 'Enviar'))
        ->getForm();
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid()){
            $producto = $formulario->getData();
            $entityManager = $doctrine->getManager();
            $entityManager -> persist($producto);
            $entityManager -> flush();
            return $this -> redirectToRoute('ficha_producto', ["codigo" => $producto->getId()]);
        }

        return $this->render('nuevo.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }

    /**
    * @Route("/producto/editar/{codigo}", name="editar_producto",requirements={"codigo"="\d+"})
    */

    public function editar(ManagerRegistry $doctrine, Request $request, $codigo) {
        $repositorio = $doctrine->getRepository(Producto::class);

        $producto = $repositorio->find($codigo);

        $formulario = $this->createFormBuilder($producto)
        ->add('producto', TextType::class)
        ->add('modelo', TextType::class)
        ->add('caracteristicas', TextType::class)
        ->add('precio', TextType::class)
        ->add('tienda', EntityType::class , array('class' => Tienda::class, 'choice_label' => 'nombre',))
        ->add('save', SubmitType::class, array('label' => 'Enviar'))
        ->getForm();

        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid()){
            $producto = $formulario->getData();
            $entityManager = $doctrine->getManager();
            $entityManager -> persist($producto);
            $entityManager -> flush();
            return $this -> redirectToRoute('ficha_producto', ["codigo" => $producto->getId()]);
        }

        return $this->render('editar.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }

    /**
     * @Route("/producto/insertar", name="insertar_producto")
     */
    
    public function insertar(ManagerRegistry $doctrine){
        $entityManager = $doctrine->getManager();
        foreach($this->productos as $p){
            $producto = new Producto();
            $producto->setProducto($p["producto"]);
            $producto->setModelo($p["modelo"]);
            $producto->setCaracteristicas($p["caracteristicas"]);
            $producto->setPrecio($p["precio"]);
            $entityManager->persist($producto);
        }

        try{
            $entityManager->flush();
            return new Response("Productos insertado");
        } catch (\Exception $e){
            return new Response("Error insertando objetos!");
        }
    }

    /**
     * @Route("/producto/{codigo}", name="ficha_producto")
     */
    public function ficha(ManagerRegistry $doctrine, $codigo): Response{
        $repositorio = $doctrine->getRepository(Producto::class);
        $producto = $repositorio->find($codigo);

            return $this->render('ficha_producto.html.twig', [
                'producto' => $producto
            ]);
        }

    /**
     * @Route("/producto/buscar/{texto}", name="buscar_producto")
     */
    public function buscar(ManagerRegistry $doctrine, $texto): Response{
        $repositorio = $doctrine->getRepository(Producto::class);

        $producto = $repositorio->findByName($texto);

        return $this->render('lista_productos.html.twig', [
            'productos' => $producto
        ]);
    }    

    /**
     * @Route("/producto/update/{id}/{productoNombre}", name="modificador_producto")
     */

    public function update(ManagerRegistry $doctrine, $id, $productoNombre): Response{
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Producto::class);
        $producto = $repositorio->find($id);
        if($producto){
            $producto->setProducto($productoNombre);
            try{
                $entityManager->flush();
                return $this->render('ficha_producto.html.twig', [
                    'producto' => $producto
                ]);
            }catch (\Exception $e){
                return new Response("Error insertando objetos");
            }
        }else{
            return $this->render('ficha_producto.html.twing' , [
                'producto' => null
            ]);
        }
    }

    /**
     * @Route("/producto/delete/{id}", name="eliminar_producto")
     */
    public function delete(ManagerRegistry $doctrine, $id): Response{
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Producto::class);
        $producto = $repositorio->find($id);
        if($producto){
            try{
                $entityManager->remove($producto);
                $entityManager->flush();
                return new Response("Producto eliminado");
            }catch (\Exception $e){
                return new Response("Error eliminar objeto");
            }
        }else{
            return $this->render('ficha_producto.html.twing' , [
                'producto' => null
            ]);
        }
    }

}
?>