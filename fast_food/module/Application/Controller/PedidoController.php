<?php

namespace Application\Controller;

use Application\Exception\ValidationException;
use Application\Helper\Message;
use Application\Model\PedidoModel;
use Application\View\ApplicationView;
use Szy\Mvc\Model\ModelException;

class PedidoController extends AdminController
{
    public function indexAction()
    {
        // TODO: Implement indexAction() method.
    }

    public function abertosAction()
	{
		$view = new ApplicationView($this, 'pedido/index');
		$view->setTitle('Pedidos abertos');

		$model = new PedidoModel();
		$view->setAttribute('pedidos', $model->pedidosAbertos());

		$view->flush();
	}

	public function detalhesAction($codigo)
	{
		$view = new ApplicationView($this, 'pedido/detalhe');
		try {
			$codigo = trim($codigo);
			if (empty($codigo))
				throw new ValidationException('Código do pedido inválido');

			$model = new PedidoModel();
			//var_dump($model->detalhes($codigo));
			//exit;
			$view->setAttribute('pedido', $model->detalhes($codigo));
		} catch (ModelException $ex) {
			$view->setMessage(new Message($ex->getMessage(), Message::TYPE_DANGER));
		}
		$view->flush();
	}
}