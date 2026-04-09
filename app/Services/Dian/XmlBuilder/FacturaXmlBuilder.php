<?php

namespace App\Services\Dian\XmlBuilder;

use DOMDocument;
use DOMElement;

/**
 * FacturaXmlBuilder - Versión FINAL DIAN-compliant
 *
 * - Invoice / CreditNote / DebitNote
 * - Agrupa impuestos por porcentaje y genera TaxTotal global (TaxSubtotal por tarifa)
 * - AllowanceCharge => otros cargos (aumentan el payable)
 * - WithholdingTaxTotal => deducciones (retenidos)
 * - LegalMonetaryTotal antes de InvoiceLine (DIAN requirement)
 * - UUID (CUFE) calculado y ubicado justo después de cbc:ID
 * - No ds:Signature (se firma después)
 */
class FacturaXmlBuilder
{
    public function generarXML(array $todo, string $documentType = 'Invoice'): string
    {

         $enc = $todo['encabezado'];

        // Determinar nodo raíz según tipo
        $rootName = $documentType; // Invoice, CreditNote, DebitNote

        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        // Crear nodo raíz
        $root = $xml->createElement($rootName);
        $xml->appendChild($root);

        // Namespaces obligatorios UBL 2.1
        $root->setAttribute('xmlns', "urn:oasis:names:specification:ubl:schema:xsd:{$rootName}-2");
        $root->setAttribute('xmlns:cac', "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2");
        $root->setAttribute('xmlns:cbc', "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2");

        // =============================
        // DATOS BÁSICOS DEL DOCUMENTO
        // =============================

        // UBL Version
        $root->appendChild($xml->createElement('cbc:UBLVersionID', '2.1'));

        // CustomizationID (10 = Factura electrónica DIAN)
        $root->appendChild($xml->createElement('cbc:CustomizationID', '10'));

        // ProfileID
        $root->appendChild($xml->createElement('cbc:ProfileID', 'DIAN 2.1'));

        // ProfileExecutionID (2 = pruebas, 1 = producción)
        $root->appendChild($xml->createElement('cbc:ProfileExecutionID', '2'));

        // ID (prefijo + número)
        $root->appendChild($xml->createElement('cbc:ID', $enc['prefijo'] . $enc['numero']));

        // Fecha
        $root->appendChild($xml->createElement('cbc:IssueDate', $enc['fecha']));

        // Hora
        $horaFormateada = $enc['hora'] . "-05:00";
        $root->appendChild($xml->createElement('cbc:IssueTime', $horaFormateada));

        // Tipo documento
        $root->appendChild($xml->createElement('cbc:InvoiceTypeCode', $enc['invoice_type_code']));

        // Moneda
        $root->appendChild($xml->createElement('cbc:DocumentCurrencyCode', 'COP'));


        // ======================================
        // ACCOUNTING SUPPLIER PARTY (NOTARÍA)
        // ======================================

        $empresa = $todo['empresa'];

        $accountingSupplierParty = $xml->createElement('cac:AccountingSupplierParty');
        $party = $xml->createElement('cac:Party');

        // PartyIdentification
        $partyIdentification = $xml->createElement('cac:PartyIdentification');
        $id = $xml->createElement('cbc:ID', $empresa['nit']);
        $id->setAttribute('schemeID', '31');
        $partyIdentification->appendChild($id);
        $party->appendChild($partyIdentification);

        // PartyName
        $partyName = $xml->createElement('cac:PartyName');
        $partyName->appendChild($xml->createElement('cbc:Name', $empresa['nombre']));
        $party->appendChild($partyName);

        // Address
        $physicalLocation = $xml->createElement('cac:PhysicalLocation');
        $address = $xml->createElement('cac:Address');

        $address->appendChild($xml->createElement('cbc:ID', $empresa['codigo_ciudad']));
        $address->appendChild($xml->createElement('cbc:CityName', $empresa['ciudad']));
        $address->appendChild($xml->createElement('cbc:CountrySubentity', $empresa['departamento']));
        $address->appendChild($xml->createElement('cbc:CountrySubentityCode', $empresa['codigo_departamento']));

        $country = $xml->createElement('cac:Country');
        $country->appendChild($xml->createElement('cbc:IdentificationCode', 'CO'));
        $country->appendChild($xml->createElement('cbc:Name', 'COLOMBIA'));

        $address->appendChild($country);
        $physicalLocation->appendChild($address);
        $party->appendChild($physicalLocation);

        // PartyTaxScheme
        $partyTaxScheme = $xml->createElement('cac:PartyTaxScheme');

        $companyID = $xml->createElement('cbc:CompanyID', $empresa['nit']);
        $companyID->setAttribute('schemeID', $empresa['dv_empresa']);
        $companyID->setAttribute('schemeName', '31');
        $companyID->setAttribute('schemeAgencyID', '195');
        $companyID->setAttribute('schemeAgencyName', 'CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)');

        $partyTaxScheme->appendChild($companyID);
        $partyTaxScheme->appendChild(
        $xml->createElement('cbc:TaxLevelCode', $empresa['responsabilidad_fiscal'])
        );

        $taxScheme = $xml->createElement('cac:TaxScheme');
        $taxScheme->appendChild($xml->createElement('cbc:ID', '01'));
        $taxScheme->appendChild($xml->createElement('cbc:Name', 'IVA'));
        $partyTaxScheme->appendChild($taxScheme);

        $party->appendChild($partyTaxScheme);

        // PartyLegalEntity
        $partyLegalEntity = $xml->createElement('cac:PartyLegalEntity');
        $partyLegalEntity->appendChild(
        $xml->createElement('cbc:RegistrationName', $empresa['nombre'])
        );

        $party->appendChild($partyLegalEntity);

        $accountingSupplierParty->appendChild($party);
        $root->appendChild($accountingSupplierParty);



        /* ======================================
        ACCOUNTING CUSTOMER PARTY (CLIENTE)
        ====================================== */

        $cliente = $todo['cliente'];

        $accountingCustomerParty = $xml->createElement('cac:AccountingCustomerParty');
        $partyCustomer = $xml->createElement('cac:Party');

        // PartyIdentification
        $partyIdentification = $xml->createElement('cac:PartyIdentification');
        $customerID = $xml->createElement('cbc:ID', $cliente['id']);
        $customerID->setAttribute('schemeID', $cliente['tipo_doc']);
        $partyIdentification->appendChild($customerID);
        $partyCustomer->appendChild($partyIdentification);

        // PartyName
        if (!empty($cliente['nombre'])) {
        $partyName = $xml->createElement('cac:PartyName');
        $partyName->appendChild(
        $xml->createElement('cbc:Name', $cliente['nombre'])
        );
        $partyCustomer->appendChild($partyName);
        }

        // Dirección
        if (!empty($cliente['codigo_ciudad'])) {

        $physicalLocation = $xml->createElement('cac:PhysicalLocation');
        $address = $xml->createElement('cac:Address');

        $address->appendChild(
        $xml->createElement('cbc:ID', $cliente['codigo_ciudad'])
        );
        $address->appendChild(
        $xml->createElement('cbc:CityName', $cliente['ciudad'])
        );
        $address->appendChild(
        $xml->createElement('cbc:CountrySubentity', $cliente['departamento'])
        );
        $address->appendChild(
        $xml->createElement('cbc:CountrySubentityCode', $cliente['codigo_departamento'])
        );

        $country = $xml->createElement('cac:Country');
        $country->appendChild($xml->createElement('cbc:IdentificationCode', 'CO'));
        $country->appendChild($xml->createElement('cbc:Name', 'COLOMBIA'));

        $address->appendChild($country);
        $physicalLocation->appendChild($address);
        $partyCustomer->appendChild($physicalLocation);
        }

        // PartyTaxScheme SOLO si es NIT
        if ($cliente['tipo_doc'] == '31' && !empty($cliente['dv'])) {

        $partyTaxScheme = $xml->createElement('cac:PartyTaxScheme');

        $companyID = $xml->createElement('cbc:CompanyID', $cliente['id']);
        $companyID->setAttribute('schemeName', '31');
        $companyID->setAttribute('schemeID', $cliente['dv']);
        $companyID->setAttribute('schemeAgencyID', '195');
        $companyID->setAttribute('schemeAgencyName', 'CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)');

        $partyTaxScheme->appendChild($companyID);
        $partyCustomer->appendChild($partyTaxScheme);
        }

        // PartyLegalEntity
        $partyLegalEntity = $xml->createElement('cac:PartyLegalEntity');
        $partyLegalEntity->appendChild(
        $xml->createElement('cbc:RegistrationName', $cliente['nombre'])
        );

        $partyCustomer->appendChild($partyLegalEntity);

        $accountingCustomerParty->appendChild($partyCustomer);
        $root->appendChild($accountingCustomerParty);



        /* ======================================
        PAYMENT MEANS
        ====================================== */

        $paymentMeans = $xml->createElement('cac:PaymentMeans');

        $paymentMeansCode = $xml->createElement(
        'cbc:PaymentMeansCode',
        $todo['encabezado']['medio_pago'] ?? '10'
        );

        $paymentMeans->appendChild($paymentMeansCode);

        $paymentDueDate = $xml->createElement(
        'cbc:PaymentDueDate',
        $todo['encabezado']['fecha']
        );

        $paymentMeans->appendChild($paymentDueDate);

        $paymentID = $xml->createElement('cbc:PaymentID', '1');
        $paymentMeans->appendChild($paymentID);

        $root->appendChild($paymentMeans);

            /* ======================================
            TAX TOTAL (IVA GLOBAL)
            ====================================== */

            $totales = $todo['totales'];

            $taxTotal = $xml->createElement('cac:TaxTotal');

            $taxAmount = $xml->createElement(
            'cbc:TaxAmount',
            number_format($totales['iva'], 2, '.', '')
            );
            $taxAmount->setAttribute('currencyID', 'COP');
            $taxTotal->appendChild($taxAmount);

            // Subtotal IVA
            $taxSubtotal = $xml->createElement('cac:TaxSubtotal');

            $taxableAmount = $xml->createElement(
            'cbc:TaxableAmount',
            number_format($totales['subtotal_sin_iva'], 2, '.', '')
            );
            $taxableAmount->setAttribute('currencyID', 'COP');
            $taxSubtotal->appendChild($taxableAmount);

            $taxSubAmount = $xml->createElement(
            'cbc:TaxAmount',
            number_format($totales['iva'], 2, '.', '')
            );
            $taxSubAmount->setAttribute('currencyID', 'COP');
            $taxSubtotal->appendChild($taxSubAmount);

            $percent = 0;
            if ($totales['iva'] > 0 && $totales['subtotal_sin_iva'] > 0) {
                $percent = ($totales['iva'] / $totales['subtotal_sin_iva']) * 100;
            }

            $taxSubtotal->appendChild(
            $xml->createElement('cbc:Percent', number_format($percent, 2, '.', ''))
            );

            $taxCategory = $xml->createElement('cac:TaxCategory');
            $taxScheme = $xml->createElement('cac:TaxScheme');
            $taxScheme->appendChild($xml->createElement('cbc:ID', '01'));
            $taxScheme->appendChild($xml->createElement('cbc:Name', 'IVA'));
            $taxCategory->appendChild($taxScheme);
            $taxSubtotal->appendChild($taxCategory);

            $taxTotal->appendChild($taxSubtotal);
            $root->appendChild($taxTotal);


            /* ======================================
            WITHHOLDING TAX TOTAL (DEDUCCIONES)
            ====================================== */

            foreach ($todo['deducciones'] as $ded) {

                $withholdingTaxTotal = $xml->createElement('cac:WithholdingTaxTotal');

                $taxAmount = $xml->createElement(
                'cbc:TaxAmount',
                number_format($ded['tax'], 2, '.', '')
                );
                $taxAmount->setAttribute('currencyID', 'COP');
                $withholdingTaxTotal->appendChild($taxAmount);

                $taxSubtotal = $xml->createElement('cac:TaxSubtotal');

                $taxableAmount = $xml->createElement(
                'cbc:TaxableAmount',
                number_format($ded['base'], 2, '.', '')
                );
                $taxableAmount->setAttribute('currencyID', 'COP');
                $taxSubtotal->appendChild($taxableAmount);

                $taxSubAmount = $xml->createElement(
                'cbc:TaxAmount',
                number_format($ded['tax'], 2, '.', '')
                );
                $taxSubAmount->setAttribute('currencyID', 'COP');
                $taxSubtotal->appendChild($taxSubAmount);

                $taxSubtotal->appendChild(
                $xml->createElement('cbc:Percent', number_format($ded['rate'], 2, '.', ''))
                );

                $taxCategory = $xml->createElement('cac:TaxCategory');
                $taxScheme = $xml->createElement('cac:TaxScheme');
                $taxScheme->appendChild($xml->createElement('cbc:ID', $ded['id']));
                $taxScheme->appendChild($xml->createElement('cbc:Name', $ded['name']));
                $taxCategory->appendChild($taxScheme);
                $taxSubtotal->appendChild($taxCategory);

                $withholdingTaxTotal->appendChild($taxSubtotal);

                $root->appendChild($withholdingTaxTotal);
            }


            /* ======================================
            LEGAL MONETARY TOTAL
            ====================================== */

            $legalMonetaryTotal = $xml->createElement('cac:LegalMonetaryTotal');

            $lineExtensionAmount = $xml->createElement(
            'cbc:LineExtensionAmount',
            number_format($totales['subtotal_sin_iva'], 2, '.', '')
            );
            $lineExtensionAmount->setAttribute('currencyID', 'COP');

            $taxExclusiveAmount = $xml->createElement(
            'cbc:TaxExclusiveAmount',
            number_format($totales['subtotal_sin_iva'], 2, '.', '')
            );
            $taxExclusiveAmount->setAttribute('currencyID', 'COP');

            $taxInclusiveAmount = $xml->createElement(
            'cbc:TaxInclusiveAmount',
            number_format($totales['subtotal_sin_iva'] + $totales['iva'], 2, '.', '')
            );
            $taxInclusiveAmount->setAttribute('currencyID', 'COP');

            $payableAmount = $xml->createElement(
            'cbc:PayableAmount',
            number_format($totales['total_factura'], 2, '.', '')
            );
            $payableAmount->setAttribute('currencyID', 'COP');

            $legalMonetaryTotal->appendChild($lineExtensionAmount);
            $legalMonetaryTotal->appendChild($taxExclusiveAmount);
            $legalMonetaryTotal->appendChild($taxInclusiveAmount);
            $legalMonetaryTotal->appendChild($payableAmount);

            $root->appendChild($legalMonetaryTotal);


            /* ======================================
            ALLOWANCE CHARGE (OTROS CARGOS)
            ====================================== */

            foreach ($todo['otroscargos'] as $cargo) {

                if ($cargo['amount'] <= 0) continue;

                    $allowanceCharge = $xml->createElement('cac:AllowanceCharge');

                    $allowanceCharge->appendChild(
                    $xml->createElement('cbc:ChargeIndicator', 'true')
                    );

                    $allowanceCharge->appendChild(
                    $xml->createElement('cbc:AllowanceChargeReason', $cargo['name'])
                    );

                    $amount = $xml->createElement(
                    'cbc:Amount',
                    number_format($cargo['amount'], 2, '.', '')
                    );
                    $amount->setAttribute('currencyID', 'COP');

                    $allowanceCharge->appendChild($amount);

                    $root->appendChild($allowanceCharge);
            }


        return $xml->saveXML();
           

    }

}
