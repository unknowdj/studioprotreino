<?php

namespace Site\Controller;

use Admin\Model\Customer;
use Admin\Model\CustomerTable;
use Admin\Model\PlanTable;
use Admin\Model\Signature;
use Admin\Model\SignatureTable;
use MainClass\MainController;
use Site\Form\Contact\ContactForm;
use Site\Form\Customer\CustomerForm;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class IndexController
 * @package Site\Controller
 */
class IndexController extends MainController
{
    /**
     * @var ContactForm
     */
    private $formContact;
    /**
     * @var CustomerForm
     */
    private $customerForm;
    /**
     * @var PlanTable
     */
    private $planTable;
    /**
     * @var
     */
    private $customerTable;
    /**
     * @var
     */
    private $signatureTable;

    /**
     * IndexController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     * @param PlanTable $planTable
     * @param CustomerTable $customerTable
     * @param SignatureTable $signatureTable
     * @param ContactForm $contactForm
     */
    function __construct(AdapterInterface $dbAdapter,
                         PhpRenderer $phpRender,
                         PlanTable $planTable,
                         CustomerTable $customerTable,
                         SignatureTable $signatureTable,
                         ContactForm $contactForm,
                         CustomerForm $customerForm)
    {
        parent::__construct($dbAdapter, $phpRender);

        $this->formContact = $contactForm;
        $this->customerForm = $customerForm;

        $this->planTable = $planTable;
        $this->customerTable = $customerTable;
        $this->signatureTable = $signatureTable;

        $this->_sessionModule = self::MODULE_SITE;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $plans = $this->planTable->fetchPlanActiveWithCategory();
        $this->formContact->setAttribute('action', $this->url()->fromRoute('contact'));
        $this->_view->setVariable('form', $this->formContact);
        $this->_view->setVariable('plans', $plans);
        return $this->_view;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function purchaseAction()
    {
        $planId = $this->getParam('planId', 0);
        $this->setForm($this->customerForm, 'plans/purchase', ['planId' => $planId], $this->translate('Purchase'));

        if ($this->isAjaxRequest()) {
            $this->initTransaction();
            try {
                $this->setPost();
                $this->validForm();
                $this->createSignature();
//                $this->notifyUser();
                $this->setFlashMessageSuccess();
                $this->transaction->commit();
            } catch (AdminException $e) {
                $this->processRollback($this->translate('Attention'), $e, 'warning');
            } catch (\Exception $e) {
                $this->processRollback($this->translate('Error'), $e, 'error');
            }
            $data['redirectUrl'] = $this->url()->fromRoute('plans/success');
            return $this->sendAjaxResponse($data);
        }

        $this->customerForm->get('plan_id')->setValue($planId);
        return $this->_view->setVariables([
            'form' => $this->customerForm
        ]);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function successAction()
    {
        return $this->_view;
    }

    /**
     * CREATE SIGNATURE
     */
    private function createSignature()
    {
        $customer = new Customer();
        $customer->exchangeArray($this->post);
        $customer->active = self::ACTIVE;
        $customerId = $this->customerTable->save($customer, null);

        $plan = $this->planTable->findById($this->post['plan_id']);

        $signature = new Signature();
        $signature->plan_id = $plan->id;
        $signature->customer_id = $customerId;
        $signature->date_initial = $this->dateNow();
        $signature->date_end = $this->dateNow();
        $signature->value = $plan->value;
        $signature->active = self::NOT_ACTIVE;
        $this->signatureTable->save($signature, null);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function contactAction()
    {
        if ($this->isAjaxRequest()) {
            try {
                $this->setPost();

                $msg = 'Contato - PRO TREINO <br>';
                $msg .= '================================= <br>';
                $msg .= 'NOME: <br>';
                $msg .= $this->post['name'] . '<br>';
                $msg .= 'TELEFONE: <br>';
                $msg .= $this->post['phone'] . '<br>';
                $msg .= 'QUAL É SEU OBJETIVO?: <br>';
                if (is_array($this->post['service'])) {
                    $msg .= implode(' - ', $this->post['service']) . '<br>';
                }
                $msg .= '================================= <br>';
                $msg .= 'enviado por: Pantone Web';

                $html = new Part($msg);
                $html->setCharset('utf-8');
                $html->setType("text/html");

                $body = new \Zend\Mime\Message();
                $body->addPart($html);

                $message = new Message();
                $message
                    ->addTo('contato@studioprotreino.com.br')
                    ->addFrom('nao-responda@studioprotreino.com.br')
                    ->setSubject('Contato - PRO TREINO')
                    ->setBody($body);

                $transport = new SmtpTransport();
                $options = new SmtpOptions(array(
                    'name' => 'mail.studioprotreino.com.br',
                    'host' => 'mail.studioprotreino.com.br',
                    'connection_class' => 'login',
                    'connection_config' => array(
                        'username' => 'nao-responda@studioprotreino.com.br',
                        'password' => 'uQg8_59w',
                    ),
                ));
                $transport->setOptions($options);
                $transport->send($message);
                $this->setFlashMessageSuccess('E-mail enviado com sucesso!');
            } catch (AdminException $e) {
                $this->processRollback($this->translate('Attention'), $e, 'warning');
            } catch (\Exception $e) {
                $this->processRollback($this->translate('Error'), $e, 'error');
            }
            $data['redirectUrl'] = $this->url()->fromRoute('contact');
        }
        return $this->sendAjaxResponse($data);
    }
}
