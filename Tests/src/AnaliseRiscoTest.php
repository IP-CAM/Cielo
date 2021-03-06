<?php
namespace Tritoq\Payment\Tests;


use Tritoq\Payment\Cielo\AnaliseRisco;
use Tritoq\Payment\Cielo\AnaliseRisco\PedidoAnaliseRisco;

/**
 *
 * Classe de teste unitário para verificação da Analise de Risco e geração do XML
 *
 *
 * Class AnaliseRiscoTest
 *
 * @category Library
 * @copyright Artur Magalhães <nezkal@gmail.com>
 * @package Tritoq\Payment\Tests
 * @license GPL-3.0+
 */
class AnaliseRiscoTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AnaliseRisco
     */
    protected $analise;

    /**
     *  Configurações iniciais
     */
    public function setUp()
    {
        $pedido = new PedidoAnaliseRisco();
        $pedido
            ->setEstado('SC')
            ->setCep('89802140')
            ->setCidade('Chapeco')
            ->setComplemento('Sala 1008')
            ->setEndereco('Rua Marechal Deodoro, 400')
            ->setId('123345')
            ->setPais('BR')
            ->setPrecoTotal(400.00)
            ->setPrecoUnitario(390.00);
        //
        $cliente = new AnaliseRisco\Modelo\ClienteAnaliseRiscoTest();
        $cliente->nome = 'Artur';
        $cliente->sobrenome = 'Magahalhaes';
        $cliente->endereco = 'Rua Marechal Deodoro, 400';
        $cliente->complemento = 'Sala 1008';
        $cliente->cep = '89802140';
        $cliente->documento = '123456789123';
        $cliente->email = 'artur@tritoq.com';
        $cliente->estado = 'SC';
        $cliente->cidade = 'Chapeco';
        $cliente->id = '9024';
        $cliente->ip = '192.168.1.254';
        $cliente->pais = 'BR';
        $cliente->senha = '12345';
        $cliente->telefone = '49912341234';

        $this->analise = new AnaliseRisco();
        $this->analise
            ->setCliente($cliente)
            ->setPedido($pedido)
            ->setAfsServiceRun(true)
            ->setAltoRisco(AnaliseRisco::ACAO_MANUAL_POSTERIOR)
            ->setMedioRisco(AnaliseRisco::ACAO_MANUAL_POSTERIOR)
            ->setBaixoRisco(AnaliseRisco::ACAO_CAPTURAR)
            ->setErroDados(AnaliseRisco::ACAO_MANUAL_POSTERIOR)
            ->setErroIndisponibilidade(AnaliseRisco::ACAO_MANUAL_POSTERIOR);

        if (!is_dir(OUTPUT . 'xml')) {
            mkdir(OUTPUT . 'xml', 0775);
        }
    }

    /**
     *  Cria o XML e salva na pasta de saída de testes
     */
    public function testCriarXml()
    {
        $xml = $this->analise->criarXml();
        $xml->asXML(OUTPUT . 'xml/analise-risco.xml');

    }

}
 