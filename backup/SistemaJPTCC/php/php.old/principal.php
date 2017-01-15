<?php

include 'sistemaJP.php';
date_default_timezone_set('America/Sao_Paulo'); //fuso horario

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'gerarGrafico':
            gerarGrafico();
            break;
    }
}

//=======================================================================================
// ========Função: Retorna um Json para o Js, com o objetivo de gerar o gráfico
//=======================================================================================
function gerarGrafico(){

    $data = explode(",", nomeDiaSemana());

    //=======================================================================================
    // ========SEGUNDA-FEIRA
    //=======================================================================================

    if ($data[1] == "Segunda-Feira"){

        $dataIni = strtotime($data[0]);

        $dataIniPassada = strtotime('-7 day', $dataIni);
        //$dataIni = date('Y-m-d', $dataIni);

        $dataFinal = strtotime($data[0]);

        $dataFinalPassada = strtotime('-7 day', $dataFinal);
        //$dataFinal = date('Y-m-d', $dataFinal);

        $arrayValorSemana = select($dataIni, $dataFinal);

        $arrayValorSemanaAnt = select($dataIniPassada, $dataFinalPassada);
        //if($arrayValorSemana == null)
        $json[] = array(
            'segunda' => $arrayValorSemana[0],
            'terca' => 0,
            'quarta' => 0,
            'quinta' => 0,
            'sexta' => 0,
            'sabado' => 0,
            'domingo' => 0,
            'segundaPassada' => $arrayValorSemanaAnt[0],
            'tercaPassada' => 0,
            'quartaPassada' => 0,
            'quintaPassada' => 0,
            'sextaPassada' => 0,
            'sabadoPassada' => 0,
            'domingoPassada' => 0,
        );
        echo json_encode($json);
    }

    //=======================================================================================
    // ========TERÇA-FEIRA
    //=======================================================================================

    if ($data[1] == "Terca-Feira"){

        $dataIni = strtotime($data[0]);
        $dataIni = strtotime('-1 day', $dataIni);
        //$dataIni = date('Y-m-d', $dataIni);

        $dataIniPassada = strtotime('-7 day', $dataIni);

        $dataFinal = strtotime($data[0]);
        //$dataFinal = date('Y-m-d', $dataFinal);

        $dataFinalPassada = strtotime('-7 day', $dataFinal);

        $arrayValorSemana = select($dataIni, $dataFinal);

        $arrayValorSemanaAnt = select($dataIniPassada, $dataFinalPassada);

        $json[] = array(
            'segunda' => $arrayValorSemana[0],
            'terca' => $arrayValorSemana[1],
            'quarta' => 0,
            'quinta' => 0,
            'sexta' => 0,
            'sabado' => 0,
            'domingo' => 0,
            'segundaPassada' => $arrayValorSemanaAnt[0],
            'tercaPassada' => $arrayValorSemanaAnt[1],
            'quartaPassada' => 0,
            'quintaPassada' => 0,
            'sextaPassada' => 0,
            'sabadoPassada' => 0,
            'domingoPassada' => 0,
        );
        echo json_encode($json);
    }

    //=======================================================================================
    // ========QUARTA-FEIRA
    //=======================================================================================

    if ($data[1] == "Quarta-Feira"){

        $dataIni = strtotime($data[0]);
        $dataIni = strtotime('-2 day', $dataIni);
        //$dataIni = date('Y-m-d', $dataIni);

        $dataFinal = strtotime($data[0]);
        //$dataFinal = date('Y-m-d', $dataFinal);

        $dataIniPassada = strtotime('-7 day', $dataIni);
        $dataFinalPassada = strtotime('-7 day', $dataFinal);
        $arrayValorSemanaAnt = select($dataIniPassada, $dataFinalPassada);
        $arrayValorSemana = select($dataIni, $dataFinal);

        $json[] = array(
            'segunda' => $arrayValorSemana[0],
            'terca' => $arrayValorSemana[1],
            'quarta' => $arrayValorSemana[2],
            'quinta' => 0,
            'sexta' => 0,
            'sabado' => 0,
            'domingo' => 0,
            'segundaPassada' => $arrayValorSemanaAnt[0],
            'tercaPassada' => $arrayValorSemanaAnt[1],
            'quartaPassada' => $arrayValorSemanaAnt[2],
            'quintaPassada' => 0,
            'sextaPassada' => 0,
            'sabadoPassada' => 0,
            'domingoPassada' => 0,
        );
        echo json_encode($json);
    }

    //=======================================================================================
    // ========QUINTA-FEIRA
    //=======================================================================================

    if ($data[1] == "Quinta-Feira"){

        $dataIni = strtotime($data[0]);
        $dataIni = strtotime('-3 day', $dataIni);
        //$dataIni = date('Y-m-d', $dataIni);

        $dataFinal = strtotime($data[0]);
        //$dataFinal = date('Y-m-d', $dataFinal);

        $dataIniPassada = strtotime('-7 day', $dataIni);
        $dataFinalPassada = strtotime('-7 day', $dataFinal);
        $arrayValorSemanaAnt = select($dataIniPassada, $dataFinalPassada);

        $arrayValorSemana = select($dataIni, $dataFinal);

        $json[] = array(
            'segunda' => $arrayValorSemana[0],
            'terca' => $arrayValorSemana[1],
            'quarta' => $arrayValorSemana[2],
            'quinta' => $arrayValorSemana[3],
            'sexta' => 0,
            'sabado' => 0,
            'domingo' => 0,
            'segundaPassada' => $arrayValorSemanaAnt[0],
            'tercaPassada' => $arrayValorSemanaAnt[1],
            'quartaPassada' => $arrayValorSemanaAnt[2],
            'quintaPassada' => $arrayValorSemanaAnt[3],
            'sextaPassada' => 0,
            'sabadoPassada' => 0,
            'domingoPassada' => 0,
        );
        echo json_encode($json);
    }

    //=======================================================================================
    // ========SEXTA-FEIRA
    //=======================================================================================

    if ($data[1] == "Sexta-Feira"){

        $dataIni = strtotime($data[0]);
        $dataIni = strtotime('-4 day', $dataIni);
        //$dataIni = date('Y-m-d', $dataIni);

        $dataFinal = strtotime($data[0]);
        //$dataFinal = date('Y-m-d', $dataFinal);

        $dataIniPassada = strtotime('-7 day', $dataIni);
        $dataFinalPassada = strtotime('-7 day', $dataFinal);
        $arrayValorSemanaAnt = select($dataIniPassada, $dataFinalPassada);

        $arrayValorSemana = select($dataIni, $dataFinal);

        $json[] = array(
            'segunda' => $arrayValorSemana[0],
            'terca' => $arrayValorSemana[1],
            'quarta' => $arrayValorSemana[2],
            'quinta' => $arrayValorSemana[3],
            'sexta' => $arrayValorSemana[4],
            'sabado' => 0,
            'domingo' => 0,
            'segundaPassada' => $arrayValorSemanaAnt[0],
            'tercaPassada' => $arrayValorSemanaAnt[1],
            'quartaPassada' => $arrayValorSemanaAnt[2],
            'quintaPassada' => $arrayValorSemanaAnt[3],
            'sextaPassada' => $arrayValorSemanaAnt[4],
            'sabadoPassada' => 0,
            'domingoPassada' => 0,

        );
        echo json_encode($json);        
    }

    //=======================================================================================
    // ========SABADO
    //=======================================================================================

    if ($data[1] == "Sábado"){

        $dataIni = strtotime($data[0]);
        $dataIni = strtotime('-5 day', $dataIni);
        //$dataIni = date('Y-m-d', $dataIni);

        $dataFinal = strtotime($data[0]);
        //$dataFinal = date('Y-m-d', $dataFinal);

        $dataIniPassada = strtotime('-7 day', $dataIni);
        $dataFinalPassada = strtotime('-7 day', $dataFinal);
        $arrayValorSemanaAnt = select($dataIniPassada, $dataFinalPassada);

        $arrayValorSemana = select($dataIni, $dataFinal);

        $json[] = array(
            'segunda' => $arrayValorSemana[0],
            'terca' => $arrayValorSemana[1],
            'quarta' => $arrayValorSemana[2],
            'quinta' => $arrayValorSemana[3],
            'sexta' => $arrayValorSemana[4],
            'sabado' => $arrayValorSemana[5],
            'domingo' => 0,
            'segundaPassada' => $arrayValorSemanaAnt[0],
            'tercaPassada' => $arrayValorSemanaAnt[1],
            'quartaPassada' => $arrayValorSemanaAnt[2],
            'quintaPassada' => $arrayValorSemanaAnt[3],
            'sextaPassada' => $arrayValorSemanaAnt[4],
            'sabadoPassada' => $arrayValorSemanaAnt[5],
            'domingoPassada' => 0,
        );
        echo json_encode($json);
    }

    //=======================================================================================
    // ========DOMINGO
    //=======================================================================================

    if ($data[1] == "Domingo"){

        $dataIni = strtotime($data[0]);
        $dataIni = strtotime('-6 day', $dataIni);
        //$dataIni = date('Y-m-d', $dataIni);

        $dataFinal = strtotime($data[0]);
        //$dataFinal = date('Y-m-d', $dataFinal);

        $dataIniPassada = strtotime('-7 day', $dataIni);
        $dataFinalPassada = strtotime('-7 day', $dataFinal);
        $arrayValorSemanaAnt = select($dataIniPassada, $dataFinalPassada);

        $arrayValorSemana = select($dataIni, $dataFinal);

        $json[] = array(
            'segunda' => $arrayValorSemana[0],
            'terca' => $arrayValorSemana[1],
            'quarta' => $arrayValorSemana[2],
            'quinta' => $arrayValorSemana[3],
            'sexta' => $arrayValorSemana[4],
            'sabado' => $arrayValorSemana[5],
            'domingo' => $arrayValorSemana[6],
            'segundaPassada' => $arrayValorSemanaAnt[0],
            'tercaPassada' => $arrayValorSemanaAnt[1],
            'quartaPassada' => $arrayValorSemanaAnt[2],
            'quintaPassada' => $arrayValorSemanaAnt[3],
            'sextaPassada' => $arrayValorSemanaAnt[4],
            'sabadoPassada' => $arrayValorSemanaAnt[5],
            'domingoPassada' => $arrayValorSemanaAnt[6],
        );
        echo json_encode($json);
    }
}
//=======================================================================================
//=======================================================================================
//=======================================================================================

//=======================================================================================
// ========FUNÇÂO: Retorna a data e o nome do dia da semana atual
//=======================================================================================
function nomeDiaSemana(){

    $diaSemana = date('D');
    $mes = date('M');
    $dia = date('d');
    $ano = date('Y');
    
    $semana = array(
        'Sun' => 'Domingo', 
        'Mon' => 'Segunda-Feira',
        'Tue' => 'Terca-Feira',
        'Wed' => 'Quarta-Feira',
        'Thu' => 'Quinta-Feira',
        'Fri' => 'Sexta-Feira',
        'Sat' => 'Sábado',
    );
    //echo $semanan["$semana_n"] . $semana["$data"] . ", {$dia} de " . $mes_extenso["$mes"] . " de {$ano}";
    //echo json_encode($semana["$data"] . ", {$dia} de " . $mes_extenso["$mes"] . " de {$ano}");
    //$retorno = $semana["$data"] . ",{$dia}," . $mes_extenso["$mes"] . ",{$ano}";
   
    $dataAtual = date('Y-m-d');

    return $dataAtual . "," . $semana["$diaSemana"];
}
//=======================================================================================
//=======================================================================================
//=======================================================================================

//=======================================================================================
// ========FUNÇÂO: Retorna array com o percentual de venda de todos os dias anteriores
//                 ao dia atual da semana
//=======================================================================================
function select($dataIni, $dataFinal){
    
    $conexao = AbreBancoJP();
    $cont = 0;
    $arrayValorSemana = array();

    $inicio = date("Y-m-d", $dataIni);
    $final = date("Y-m-d", $dataFinal);

    //Pega total dos subtotais dos itens de venda, num intervalo de tempo
    $totalSemana = "select round(sum(i.subtotal),2) from item_venda i
    inner join venda v on v.idvenda = i.idvenda
    where (v.dataVenda between '$inicio' and '$final') and i.cancelado=0";

    $totalSemana = mysql_query($totalSemana, $conexao);
    $totalSemana = mysql_fetch_row($totalSemana);


    for($time = $dataIni; $time <= $dataFinal; $time = strtotime('+1 day', $time)){

        $data = date("Y-m-d", $time);

        $sql = "select round(sum(i.subtotal),2) from item_venda i
        inner join venda v on v.idvenda = i.idvenda
        where v.dataVenda = '$data' and i.cancelado = 0";

        $sql = mysql_query($sql, $conexao);

        $subTotal = mysql_fetch_row($sql);

        $valorDia = $subTotal[0];
        
        //=======================================================================================
        // ========Gerador de porcentagem desativado 03-11-14
        //=======================================================================================

        //if ($totalSemana[0] > 0)
        //    $calculo = round(($valorDia * 100) / $totalSemana[0], 3);
        //else
        //    $calculo = 0;

        //if($subTotal[0] != null && $subTotal[0] != ''){
        //    $arrayValorSemana[$cont] = $calculo;
        //}else{
        //    $arrayValorSemana[$cont] = 0;
        //}
        
        //=======================================================================================
        //=======================================================================================
        //=======================================================================================
        
        
        //Valor total vendido no dia
        if($valorDia != null && $valorDia != ''){
            $arrayValorSemana[$cont] = $valorDia;
        }else{
            $arrayValorSemana[$cont] = 0;
        }

        $cont++;
    }

    mysql_close($conexao);

    return $arrayValorSemana;
}
//=======================================================================================
//=======================================================================================
//=======================================================================================