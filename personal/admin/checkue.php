<?
define("STOP_STATISTICS", true);
define('NO_AGENT_CHECK', true);

use Bitrix\Main\Application;

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/tcpdf/tcpdf.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/tcpdf/tcpdf_autoconfig.php');
// TCPDF static font methods and data
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/tcpdf/include/tcpdf_font_data.php');
// TCPDF static font methods and data
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/tcpdf/include/tcpdf_fonts.php');
// TCPDF static color methods and data
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/tcpdf/include/tcpdf_colors.php');
// TCPDF static image methods and data
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/tcpdf/include/tcpdf_images.php');
// TCPDF static methods and data
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/tcpdf/include/tcpdf_static.php');

$request = Application::getInstance()->getContext()->getRequest();
$orderId = $request->get("orderId");
if($orderId && is_numeric($orderId) && $orderId > 0)
{
    $rsSites = \Bitrix\Main\SiteTable::getList(array(
        'select' => array('NAME'),
        'filter' => array('LID' => SITE_ID),
    ));
    if($arSite = $rsSites->fetch())
    {
        $site_name = $arSite['NAME'];
    }

    \Bitrix\Main\Loader::includeModule('iblock');

    $dbItem = \Bitrix\Iblock\ElementTable::getList(array(
        'select' => array('ID', 'IBLOCK_ID'),
        'filter' => array('ID' => $orderId),
    ));
    if ($arItem = $dbItem->fetch()) 
    {
        $dbProperty = \CIBlockElement::getProperty($arItem['IBLOCK_ID'], $arItem['ID'], array("sort", "asc"), array());
        while ($arProperty = $dbProperty->GetNext()) 
        {
            switch ($arProperty['CODE']) 
            {
                case 'PRICE':
                    $order_summ = $arProperty['VALUE'];
                    break;
                case 'DATE_START':
                    $date_start = $arProperty['VALUE'];
                    break;
                case 'DATE_END':
                    $date_end = $arProperty['VALUE'];
                    break;
                case 'ADDRESS_DELIVERY':
                    $order_address = $arProperty['VALUE'];
                    break;
                case 'ITEMS':
                    $ITEMS[] = $arProperty['VALUE'];
                    break;
                case 'TYPE_AREND':
                    $TYPE = mb_strtoupper($arProperty['VALUE']);
                    break;
            }
        }
        
        $time_period = ($TYPE == 'DAYS') ? 24 : 2;
        $QUANITY = (strtotime($date_end) - strtotime($date_start))/(60*60*$time_period);
        
        foreach($ITEMS as $item_id)
        {
            $dbProd = \Bitrix\Iblock\ElementTable::getList(array(
                'select' => array('ID', 'IBLOCK_ID', 'NAME'),
                'filter' => array('ID' => $item_id),
            ));
            if ($arProd = $dbProd->fetch()) 
            {
                $dbProdProperty = \CIBlockElement::getProperty($arProd['IBLOCK_ID'], $arProd['ID'], array("sort", "asc"), array("CODE"=>'PRICE_FOR_'.$TYPE));
                if ($arProdProperty = $dbProdProperty->GetNext()) 
                {
                    $products_html .= '
                    <tr>
                        <td class="cheque__name">'.$arProd['NAME'].' '.$arProdProperty['VALUE'].'</td>
                        <td class="cheque__quantity">'.$QUANITY.'</td>
                        <td class="cheque__price">'.(preg_replace("/[^0-9]/", '', $arProdProperty['VALUE']) * $QUANITY).' AED</td>
                    </tr>
                    
                    <tr>
                        <td class="cheque__name">&nbsp;</td>
                        <td class="cheque__quantity">&nbsp;</td>
                        <td class="cheque__price">&nbsp;</td>
                    </tr>';
                }
            }
        }
    }
    $height = count($ITEMS) * 15;

    // create new PDF document
    $pageLayout = array(57, (90 + $height));
    $pdf = new TCPDF('p', 'mm', $pageLayout, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor($site_name);
    $pdf->SetTitle($site_name.' order№'.$orderId);
    $pdf->SetSubject($site_name.' order№'.$orderId);
    $pdf->SetKeywords($site_name.', order, '.$orderId);
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/tcpdf/examples/lang/rus.php');
    $pdf->setLanguageArray($l);
    $pdf->SetFont('dejavusans', '', 10);
    // set margins
    $pdf->SetMargins(2, 1, 1);
    $pdf->SetHeaderMargin(1);
    $pdf->SetFooterMargin(1);
    // create some HTML content
    $pdf->AddPage();
    // create some HTML content
    $html = '
    <html lang="en">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                html {
                    display: block;
                }
                body {
                    display: block;
                    margin: 8px;
                }
                .cheque {
                max-width: 162px;
                width: 100%;
                padding: 0px 10px;
                margin: 0 auto;
                font-weight: 400;
                font-size: 7px;
                color: #000;
                background-color: #fff;
                }
                
                .cheque__organization {
                display: block;
                text-align: center;
                font-size: 12px;
                font-weight: 600;
                margin-left: auto;
                margin-right: auto;
                }
                
                .cheque__title {
                display: block;
                margin: 5px 0 20px;
                font-size: 10px;
                text-align: center;
                }
                
                .cheque table {
                width: 100%;
                border-spacing: 0;
                }
                
                .cheque table tbody tr td {
                padding: 0 0 10px;
                }
                
                .cheque__name {
                width: 70px;
                }
                
                .cheque__quantity {
                text-align: right;
                vertical-align: top;
                width: 24px;
                }
                
                .cheque__price {
                text-align: right;
                vertical-align: top;
                }
                
                .cheque__total {
                font-weight: 600;
                }
                
                .cheque__total-price {
                text-align: right;
                font-weight: 600;
                }
                
                .cheque__subtitle {
                display: inline-block;
                margin: 10px 0 5px;
                font-weight: 600;
                }
                
                .cheque__adress {
                margin-top: 20px;
                }
                
                .cheque__item {
                display: block;
                }
            </style>
            <title>'.$site_name.' order№'.$orderId.'</title>
        </head>
        <body>
            <div class="cheque"><br>
                <span class="cheque__organization">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$site_name.'</span><br><br>
                <span class="cheque__title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice Details</span><br><br>
                <table>

                    <tbody>
                        '.$products_html.'

                        <tr>
                            <td class="cheque__total">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="cheque__total-price">&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="cheque__total">Total</td>
                            <td></td>
                            <td class="cheque__total-price">'.$order_summ.'</td>
                        </tr>

                    </tbody>
                </table><br><br>

                <span class="cheque__subtitle">Start date and time</span><br>
                <span class="cheque__item">'.date("d.m.Y H:i:s", strtotime($date_start)).'</span><br><br>

                <span class="cheque__subtitle">End date and time</span><br>
                <span class="cheque__item">'.date("d.m.Y H:i:s", strtotime($date_end)).'</span><br><br>

                <span class="cheque__subtitle cheque__adress">Address:</span><br>
                <span class="cheque__item">'.$order_address.'</span>
            </div>
        </body>
    </html>
    ';
    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    // reset pointer to the last page
    $pdf->lastPage();
    //Close and output PDF document
    $pdf->Output('checkue.pdf', 'I');
}
else
{
    header('Location: /personal/');
}
?>