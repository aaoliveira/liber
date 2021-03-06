<?php

class EmpresasController extends AppController {
	var $name = 'Empresas';
	var $helpers = array('CakePtbr.Estados');
	var $paginate = array (
		'limit' => 10,
		'order' => array (
			'Empresa.id' => 'asc'
		)
	);

	function index() {
		if ( $this->RequestHandler->isAjax() ) {
			$this->layout = 'ajax';
		}
		$dados = $this->paginate('Empresa');
		$this->set('consulta_empresa',$dados);
	}
	
	function cadastrar() {
		if ( $this->RequestHandler->isAjax() ) {
			$this->layout = 'ajax';
		}
		if (! empty($this->request->data)) {
			
			if ($this->Empresa->save($this->request->data)) {
				$this->Session->setFlash('Empresa cadastrada com sucesso.','flash_sucesso');
				$this->redirect($this->referer(array('action' => 'index')));
			}
			else {
				$this->Session->setFlash('Erro ao cadastrar a empresa.','flash_erro');
			}
		}
	}
	
	function editar($id=NULL) {
		if ( $this->RequestHandler->isAjax() ) {
			$this->layout = 'ajax';
		}
		if (empty ($this->request->data)) {
			$this->Empresa->recursive = -1;
			$this->Empresa->id = $id;
			$this->request->data = $this->Empresa->read();
			if ( ! $this->request->data) {
				$this->Session->setFlash('Empresa não encontrada.','flash_erro');
				$this->redirect(array('action'=>'index'));
			}
		}
		else {
			$this->request->data['Empresa']['id'] = $id;
			
			if ($this->Empresa->save($this->request->data)) {
				$this->Session->setFlash('Empresa atualizada com sucesso.','flash_sucesso');
				$this->redirect(array('action'=>'index'));
			}
			else {
				$this->Session->setFlash('Erro ao atualizar a empresa.','flash_erro');
			}
		}
	}
	
	function excluir($id=NULL) {
		if ( $this->RequestHandler->isAjax() ) {
			$this->layout = 'ajax';
		}
		if (! empty($id)) {
			if ($this->Empresa->delete($id)) $this->Session->setFlash("Empresa $id excluída com sucesso.",'flash_sucesso');
			else $this->Session->setFlash("Empresa $id não pode ser excluída.",'flash_erro');
			$this->redirect(array('action'=>'index'));
		}
		else {
			$this->Session->setFlash('Empresa não informada.','flash_erro');
		}
	}
	
}

?>