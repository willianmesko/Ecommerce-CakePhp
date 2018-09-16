<?php

class WsBehavior extends ModelBehavior
{

	/*
    	Documentação dos correios: http://www.correios.com.br/para-sua-empresa/servicos-para-o-seu-contrato/precos-e-prazos/calculador-remoto-de-precos-e-prazos

    	--==SERVIÇOS==--
        SEDEX: 40010
        SEDEX 10: 40045
        SEDEX a crobrar: 40215
        SEDEX Hoje: 40290
        PAC: 41106

		--==FORMATOS==--
		Formato caixa/pacote : 1
		Formato rolo/prisma : 2
		Envelope : 3
    
    */
	public function correios(Model $model, Array $options = array())
	{
		extract($options);
		if (empty($cep_destino) or empty($servico) or empty($peso)) {
			throw new NotImplemented('Verifique todos os campos!');
		}

		$peso = $peso/1000;
		$peso = round($peso);

		if (empty($cep_origem)) $cep_origem = 11676085;
		if (empty($formato)) $formato = 1;
		if (empty($comprimento)) $comprimento = 30;
		if (empty($altura)) $altura = 30;
		if (empty($largura)) $largura = 30;
		if (empty($diametro)) $diametro = 30;
		$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem='.$cep_origem.'&sCepDestino='.$cep_destino.'&nVlPeso='.$peso.'&nCdFormato='.$formato.'&nVlComprimento='.$comprimento.'&nVlAltura='.$altura.'&nVlLargura='.$largura.'&sCdMaoPropria=n&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico='.$servico.'&nVlDiametro='.$diametro.'&StrRetorno=xml';
		$resposta = Xml::build($url);
        $resposta = Xml::toArray($resposta);
		return $resposta;
	}

	public function pagseguro(Model $model, Array $carrinho, Array $compra_dados, $frete, $email = 'erik.figueiredo@gmail.com', $token='F222E0F77C464AB9ACF9BDD2D296B206')
	{
		$data['email'] = $email;
		$data['token'] = $token;
		$data['currency'] = 'BRL';

		foreach($carrinho['produtos'] as $k=>$v) {
			$k++;
			$data['itemId'.$k] = $v['Produto']['id'];
			$data['itemDescription'.$k] = $v['Produto']['titulo'];
			$data['itemAmount'.$k] = $v['Produto']['valor'];
			
			$data['itemQuantity'.$k] = $v['qtd'];
			$peso = $v['Produto']['peso'] * 1;
			$data['itemWeight'.$k] = $peso;
		}

		$data['reference'] = $compra_dados['Compra']['id'];
		
		$data['senderName'] = $compra_dados['Usuario']['nome'].' Figueiredo';
		$data['senderEmail'] = $compra_dados['Usuario']['email'];
		$data['shippingCost'] = $frete;
		$data['shippingType'] = 3;
		$data['shippingAddressPostalCode'] = $compra_dados['Compra']['cep'];

		$data = http_build_query($data);
		if (function_exists('curl_version')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://ws.pagseguro.uol.com.br/v2/checkout/');
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$retorno = curl_exec($ch);
			curl_close($ch);
			
			$retorno = Xml::toArray(Xml::build($retorno));
			
			if (!empty($retorno['errors'])) {
				if (isset($retorno['errors']['error'][0]['message'])) {
					$msg = $retorno['errors']['error'][0]['message'];
				} else {
					$msg = $retorno['errors']['error']['message'];
				}
				return array('erro'=>true, 'msg'=>$msg);
			}
			$url = 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code='.$retorno['checkout']['code'];
			return $url;
		}
	}

	public function notificacao (Model $Model, $email = 'erik.figueiredo@gmail.com', $token='F222E0F77C464AB9ACF9BDD2D296B206')
    {
        $url="https://ws.pagseguro.uol.com.br/v2/transactions/notifications/".$_POST['notificationCode']."?email=".$email."&token=".$token;
                    
        $resposta = Xml::toArray(Xml::build($url));
        
        $retorno['Notificacao']['date'] = $resposta['transaction']['date'];
        $retorno['Notificacao']['code'] = $resposta['transaction']['code'];
        $retorno['Notificacao']['reference'] = $resposta['transaction']['reference'];
        $retorno['Notificacao']['type'] = $resposta['transaction']['type'];
        $retorno['Notificacao']['status'] = $resposta['transaction']['status'];
        $retorno['Notificacao']['lastEventDate'] = $resposta['transaction']['lastEventDate'];
        $retorno['Notificacao']['paymentMethodType'] = $resposta['transaction']['paymentMethod']['type'];
        $retorno['Notificacao']['paymentMethodCode'] = $resposta['transaction']['paymentMethod']['code'];
        $retorno['Notificacao']['grossAmount'] = $resposta['transaction']['grossAmount'];
        $retorno['Notificacao']['discountAmount'] = $resposta['transaction']['discountAmount'];
        $retorno['Notificacao']['feeAmount'] = $resposta['transaction']['feeAmount'];
        $retorno['Notificacao']['netAmount'] = $resposta['transaction']['netAmount'];
        $retorno['Notificacao']['extraAmount'] = $resposta['transaction']['extraAmount'];
        $retorno['Notificacao']['installmentCount'] = $resposta['transaction']['installmentCount'];
        $retorno['Notificacao']['senderName'] = $resposta['transaction']['sender']['name'];
        $retorno['Notificacao']['senderEmail'] = $resposta['transaction']['sender']['email'];
        $retorno['Notificacao']['senderPhone'] = $resposta['transaction']['sender']['phone']['areaCode'].' - '.$resposta['transaction']['sender']['phone']['number'];
        $retorno['Notificacao']['compra_id'] = $resposta['transaction']['reference'];
        $retorno['Notificacao']['notificationCode'] = $_POST['notificationCode'];
        
        return $retorno;
        
    }
}