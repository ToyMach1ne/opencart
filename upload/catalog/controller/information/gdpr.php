<?php
class ControllerInformationGdpr extends Controller {
	public function index() {
		$this->load->language('information/gdpr');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'language=' . $this->config->get('config_language'))
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', 'language=' . $this->config->get('config_language'))
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/gdpr', 'language=' . $this->config->get('config_language'))
		);

		$this->load->model('catalog/information');

		$information_info = $this->model_catalog_information->getInformation($this->config->get('config_gdpr_id'));

		$data['title'] = $information_info['title'];

		if ($information_info) {
			$data['gdpr'] = $this->url->link('information/information', 'information_id=' . $information_info['information_id']);
		} else {
			$data['gdpr'] = '';
		}

		$data['email'] = $this->customer->getEmail();
		$data['store'] = $this->config->get('config_name');
		$data['limit'] = $this->config->get('config_gdpr_limit');

		$data['cancel'] = $this->url->link('account/account', 'language=' . $this->config->get('config_language'));

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/gdpr', $data));
	}

	public function action() {
		$this->load->language('information/gdpr');

		$json = array();

		if (isset($this->request->post['email'])) {
			$email = $this->request->post['email'];
		} else {
			$email = '';
		}

		if (!$customer_info) {
			$json['error']['email'] = $this->language->get('error_email');
		}

		// Validate E-Mail
		$this->load->model('account/customer');

		$customer_info = $this->model_account_customer->getCustomerByEmail($email);

		if (!$customer_info) {
			$json['error']['email'] = $this->language->get('error_email');
		}

		// Validate Action
		if (isset($this->request->post['action']) && $this->request->post['action'] != 'export' && $this->request->post['action'] != 'remove') {
			$json['error']['action'] =  $this->language->get('error_action');
		}

		if (!$json) {
			if ($action == 'export') {
				token();

				$this->url->link('information/gdpr');
				// Send mail

				//$mail = new Mail();

			}


			$this->load->model('information/gbdpr');

			//$this->model_information_gbdpr->addExport


			$json['success'] =  $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function confirm() {
		$this->load->language('information/gdpr');

		$json = array();

		if (isset($this->request->post['email'])) {
			$email = $this->request->post['email'];
		} else {
			$email = '';
		}

		$this->load->model('account/customer');

		$customer_info = $this->model_account_customer->getCustomerByEmail($email);

		if ($customer_info) {
			$json['success'] = $this->language->get('text_success');

			$this->model_account_customer->getCustomerByEmail($email);

		} else {
			$json['error'] = $this->language->get('text_error');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		$this->load->language('account/gdpr_delete');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'language=' . $this->config->get('config_language'))
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', 'language=' . $this->config->get('config_language'))
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/gdpr/delete', 'language=' . $this->config->get('config_language'))
		);

		$data['text_confirm'] = sprintf($this->language->get('text_confirm'), $this->config->get('config_gdpr_limit'));

		$data['delete'] = $this->url->link('account/gdpr/success', 'language=' . $this->config->get('config_language'));

		$data['confirm'] = $this->url->link('account/account', 'language=' . $this->config->get('config_language'));

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/gdpr_delete', $data));
	}

	public function success() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/gdpr/delete', 'language=' . $this->config->get('config_language'));

			$this->response->redirect($this->url->link('account/login', 'language=' . $this->config->get('config_language')));
		}

		$this->load->language('account/gdpr_success');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'language=' . $this->config->get('config_language'))
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', 'language=' . $this->config->get('config_language'))
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/gdpr/delete', 'language=' . $this->config->get('config_language'))
		);

		$this->load->model('account/gdpr');

		$gdpr_info = $this->model_account_gdpr->getGdpr($this->customer->getId());

		if (!$gdpr_info) {
			$this->model_account_gdpr->addGdpr($this->customer->getId());
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/gdpr_success', $data));
	}
}