<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fatura Nº - #{{ $carrinho_id  }}{{ date('Y') }}</title>

    <link href="{{ asset('admin_assets/css/style_fatura.css') }}"  rel="stylesheet">

    <style type="text/css">

        .information {
            background-color: {{ $empresa->fundo }};
            color: {{ $empresa->cor }};
        }

        .table_header {
            color: {{ $empresa->cor }};
            border-bottom: 2px solid {{ $empresa->fundo }};
        }

        .table_rows {
            color: #000;
            border-bottom: 1px solid #000;
        }

        .table_total {
            color: {{ $empresa->cor }};
            background: {{ $empresa->fundo }};
            border-bottom: 1px solid {{ $empresa->fundo }};
        }

        .table_total {
            color: {{ $empresa->cor }};
            background: {{ $empresa->fundo }};
            border-bottom: 1px solid {{ $empresa->fundo }};
        }

        a {
            color: {{ $empresa->cor }};
        }

    </style>

</head>
<body>

<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 40%;">
                <h3>{{ strtoupper($empresa->nome)  }}</h3>
                <pre>
					NIF: {{ $empresa->nif }}
					Rua {{ $empresa->rua }}
					Cidade {{ $empresa->cidade }}<br />{{strtoupper($empresa->pais) }}
					<br /><br />
					Identificador: #{{ $carrinho_id  }}{{ date('Y') }}<br />
					Status: {{ $carrinho->fechado==1?'Pago':'Aberto'}}<br />Data : {{ $carrinho->data_compra }}
				</pre>


            </td>
            <td align="center">
                <img src="{{ asset('assets/img/empresa/'.$empresa->imagem)  }}" alt="Logo" width="64" class="logo"/>
                <pre align="center">{{ strtoupper($empresa->nome)  }}</pre>
            </td>
            <td align="right" style="width: 40%;">

                <h3></h3>
                <pre>
					{{ $internauta->name }}
                    NIF: {{ $internauta->nif }}
                    Rua {{ $internauta->rua }}
                    Cidade {{ $internauta->cidade }}
                    {{ $internauta->pais }}
                    Forma pagamento: {{ $tipo_pagamento[($carrinho->tipo_pagamento)-1] }}
                </pre>
            </td>
        </tr>

    </table>
</div>


<br/>

<div class="invoice">
    <h3>Identificador da Fatura #{{ $carrinho_id  }}{{ date('Y') }}</h3>
    <table width="100%">
        <thead>
        <tr>
            <th class="table_header">Descrição</th>
            <th class="table_header" align="right">Preço/Unit.</th>
            <th class="table_header" align="right">Quantidade</th>
            <th class="table_header" align="right">Total (kwz)</th>
        </tr>
        </thead>
        <tbody>

		@if(count($carrinho_produtos))

			@foreach($carrinho_produtos as $carrinho_produto)

				<tr>
					<td class="table_rows">{{ $produtos->find($carrinho_produto->produto_id)->nome }}</td>
					<td class="table_rows" align="right">{{ number_format($carrinho_produto->valor_unit,0,',','.') }}</td>
					<td class="table_rows" align="right">x {{ number_format($carrinho_produto->qtd,0,',','.') }}</td>
					<td align="right" class="table_rows">{{ number_format(($carrinho_produto->valor_unit * $carrinho_produto->qtd),2,',','.') }}</td>
				</tr>

			@endforeach

		@endif

		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td align="right" class="table_total">{{ number_format($subtotal,2,',','.') }}</td>
		</tr>

		@if(count($carrinho_impostos))

			@foreach($carrinho_impostos as $ci)

                <tr>
                    <td colspan="1" class=""></td>
                    <td class=""></td>
                    <td align="left" class="table_rows">{{ $ci->imposto }} ({{ $ci->natureza==2?number_format($ci->valor,2,",","."):''}} {{ $ci->natureza==2?'%':'' }})</td>
                    <td align="right" class="gray table_rows">{{ $ci->natureza==2?number_format((($subtotal * $ci->valor)/100),2,",","."):number_format($ci->valor,2,",",".") }}</td>
                </tr>

			@endforeach

		@endif

        </tbody>

        <tfoot>
        <tr>
            <td colspan="1"></td>
            <td></td>
            <td align="left">Total</td>
            <td align="right" class="gray table_total">{{ number_format($total,2,",",".") }}</td>
        </tr>
        </tfoot>
    </table>

	<table width="63%" class="tabela_coordenadas_bancaria">
				<tr>
					<td colspan="2" class="table_total" >COORDENADAS BANCÁRIAS AKZ</td>
				</tr>

        @if(count($contaBancarias))
            @foreach($contaBancarias as $contaBancaria)

				<tr>
					<td colspan="2" class="table_total">BANCO {{ strtoupper($bancos->find($contaBancaria->banco_id)->nome) }}</td>
				</tr>
				<tr>
					<td>CONTA N.º</td><td> {{ strtoupper($contaBancaria->conta) }}</td>
				</tr>
				<tr>
					<td>IBAN N.º</td><td> {{ strtoupper($contaBancaria->iban) }} </td>
				</tr>

            @endforeach
        @endif

</table>

</div>


<div class="information" style="position: absolute; bottom: 0;">

    <table  width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; {{ date('Y') }} http://www.solucao-binaria.com - Todos os direitos reservados.
            </td>
            <td align="right" style="width: 50%;">
                Impresso por: {{ $nome_usuarioFacturas }}
            </td>
        </tr>

    </table>
</div>
</body>
</html>
