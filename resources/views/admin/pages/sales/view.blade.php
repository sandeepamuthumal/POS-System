<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Receipt - {{ $sale->sale_code }}</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        label {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px;
        }

        table thead th {
            height: 28px;
            text-align: left;
            font-size: 14px;
            font-family: sans-serif;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }

        .heading {
            font-size: 20px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .invoice-details {
            margin-top: 20px;
            width: 60%;
            float: right;
        }

        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }

        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }


        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .company-data span {
            display: inline-block;
            font-family: sans-serif;
            font-size: 12px;
            font-weight: 500;
        }

        .customer-data span {
            display: inline-block;
            font-family: sans-serif;
            font-size: 12px;
            font-weight: 500;
        }

        .invoice-data span {
            margin-bottom: 3px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 12px;
        }

        .no-border {
            border: 1px solid #fff !important;
        }

        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }

        .bg-yellow {
            background-color: #fffa6fc4;
            color: #000;
        }

        .bg-orange {
            color: #eb8153;
            background-color: #ffc56f38;
        }

        .main-header {
            text-align: right;
            color: #414ab1;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: 35px;
            margin: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .customer-details,
        .customer-details th,
        .customer-details td {
            border: none;
        }

        .invoice-details,
        .invoice-details th,
        .invoice-details td {
            border: none;
        }

        .company-details,
        .company-details th,
        .company-details td {
            border: none;
        }

        .customer-details td {
            font-size: 10px;
        }

        .customer-details .customer-data th {
            text-align: left;
        }

        .bank-details,
        .bank-details th,
        .bank-details td {
            border: none;
        }

        .bank-details th,
        .bank-detailstd {
            font-size: 16px;
        }

        footer span {
            display: none;
        }

        footer {
            position: fixed;
            bottom: -2%;
            width: 100%;
            text-align: center;
        }

        @media print {
            body {
                background-color: #fff;
            }

            .item_table th {
                font-size: 12px;
            }

            .item_table td {
                font-size: 10px;
            }

            .main-header {
                text-align: right;
                color: #414ab1;
                font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                font-size: 35px;
                margin: 0;
            }

            .text-center {
                text-align: center;
            }

            .bg-blue {
                background-color: #414ab1;
                color: #fff;
            }

            .bg-yellow {
                background-color: #fffa6fc4;
                color: #000;
            }

            .bg-orange {
                color: #eb8153;
                background-color: #ffc56f38;
            }

            footer {
                text-align: center;
                color: #000;
                /* Text color for the footer */
                padding: 20px 0;
                margin: 0;
                /* Add some padding for spacing */
            }


            .footer-line-1 {

                display: inline-block;
                width: 14%;
                /* Adjust the width of the lines as needed */
                border-top: 1px solid #ddd;
                /* Style and color of the lines */
                margin: 0;
                /* Add spacing between the lines and text */
            }

            .footer-line-2 {
                display: inline-block;
                width: 18%;
                /* Adjust the width of the lines as needed */
                border-top: 1px solid #ddd;
                /* Style and color of the lines */
                margin: 0;
                /* Add spacing between the lines and text */
            }

            .footer-text {
                display: inline-block;
                font-size: 12px;
                /* Adjust the font size as needed */
                margin: 0 20px;
                /* Add spacing between the text and lines */
            }

            /* Add any other color-related styles here */

            /* Reset unnecessary styles for printing */

            /* Specify text color for printing */
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            p,
            span,
            label {
                color: #000;
                /* Set a suitable text color */
            }
        }
    </style>
</head>

<body>

    <table class="company-details">
        <thead>
            <tr>
                <th width="60%" colspan="2" class="text-start company-data">
                    <h4 class="text-start" style="margin:0%;font-size:20px">Circuit Galaxy (Pvt) Ltd</h4>
                    <span>No 330/4,</span> <br>
                    <span>Kaluwelgoda,</span><br>
                    <span>Makewita,</span><br>
                    <span>Ja-Ela .</span> <br>
                    <span>+94 774 222 144 , +94 713 555 165</span>
                </th>
                <th width="40%" colspan="2" class="text-end invoice-data">
                    <h4 class="main-header" style="margin:0%;color:#eb8153">Receipt</h4>
                    <span style="font-size:15px">{{ '# ' . $sale->sale_code }}</span><br>
                    <span>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</span><br>
                    <span></span> <br>
                    <span></span> <br>
                    <span></span>
                </th>
            </tr>
        </thead>
    </table>

    <table class="customer-details" style="margin-bottom: 20px">
        <thead>
            <tr>
                <th width="60%" colspan="2" class="text-start customer-data">
                    <h5 style="margin: 0;font-weight:550">Bill To : </h5>
                    <span style="font-size: 15px"><strong>{{ $customer }}</strong></span><br>
                    <span>{{ $customer_contact_no }}</span>
                </th>
                <th width="40%" colspan="2" class="text-end invoice-data">
                    <span style="text-align:right">Total Amount:</span>
                    <h4 style="margin:0%;font-size:20px;text-align:right">
                        {{ 'LKR ' . number_format($sale->sale_total, 2) }}</h4>
                </th>
            </tr>
        </thead>

    </table>

    <table>
        <thead>
            <tr class="bg-orange">
                <th>#</th>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 0;
            @endphp
            @foreach ($sale_items as $data)
                <tr>
                    <td width="10%">{{ ++$count }}</td>
                    <td>{{ $products[$data->items_id] }}</td>
                    <td width="15%" align="right">{{ number_format($data->sell_price, 2) }}</td>
                    <td width="15%" align="right">{{ $data->total_qty }}</td>
                    <td width="15%" align="right">{{ number_format($data->sell_price * $data->total_qty, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="invoice-details">
        <tbody>
            <tr style="background-color: #ffc56f38">
                <td align="right" class="total-heading">Total Amount :</td>
                <td class="total-heading" align="right">{{ 'LKR ' . number_format($sale->sale_total, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <table></table>


    <br>

    <div class="terms" style="margin-top:20px;">
        <ul>
            <li style="font-size:12px;"><i><b>Terms and condition</b> - </i>
                <ol type="i">
                    <li style="font-size: 12px;">Checkes should be drawn in favour of <strong>Circuit Galaxy (Pvt) Ltd
                        </strong>and crossed A/C payee
                        only</li>
                </ol>
            </li>
        </ul>
        <h4 style="font-size:12px;">Assuring you're Our Best Services At All Times We Remain,<br>
            Circuit Galaxy Electronic Solutions,<br>
        </h4>
        <br>
        <p style="margin-top:70px;font-size:12px">......................................... <br>Authorized Signature</p>
    </div>

    <footer>
        <div class="footer-line-1"></div>
        <div class="footer-text">
            <p>
                Circuit Galaxy Electronics,No 320/4,Kaluwelgoda,Makewita,Ja-Ela,Sri Lanka.<br>
                Tel : 0774527144,Mail : info@circuitgalaxy.lk, web : <a
                    href="http://www.circuitgalaxy.lk/">www.Circuitgalaxy.lk</a>
            </p>
        </div>
        <div class="footer-line-2"></div>
    </footer>

    <script>
        window.print();
    </script>

</body>

</html>
