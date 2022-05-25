<html>
<head>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }/*
        table, th, td {
            border: 1px solid black;
            border-spacing: 10px;
            border-collapse: separate;
        }*/

    </style>
    <title></title>
</head>
<body>

<table  >
    <tbody>
    <tr>
        <td width="335" valign="top">
            <p>
                <img
                    width="400"
                    height="129"
                    src="logo/logo.png"
                />
            </p>
        </td>
        <td width="337" valign="top">
            <br clear="ALL"/>
            <h2>
                INVOICE
            </h2>
            <p>
                Invoice # {{$pay->id}}
            </p>
            <p>
                Date: {{$pay->created_at->toDateString()}}
            </p>
            <p>
                ABN: 45645554605
            </p>
        </td>
    </tr>
    <tr>
        <td width="335" valign="top">
            <p style="font-weight: bold">
                Ship To: {{ Auth::user()->name }}
            </p>
            <p>
                Email: {{ Auth::user()->email}}
            </p>
            <p>
                @if( Auth::user()->role == 1 )
                    Company Name: {{$pay->company->name}}
                @endif
            </p>

            <p>
                Phone: +61 {{ Auth::user()->phoneNumber }}
            </p>
        </td>
        <td width="337" valign="top">
        </td>
    </tr>
    </tbody>
</table>
<table  >
    <tbody>
    <tr>
        <td width="672" valign="top">
            <p>
                <br/>
            </p>
        </td>
    </tr>
    </tbody>
</table>
<hr color="black">
<table  >
    <tbody>
    <tr >
        <td width="453">
            <h4>
                DESCRIPTION
            </h4>
        </td>
        <td width="123">
            <h4>
                Price <small>[AUD]</small>
            </h4>
        </td>
    </tr>
    <tr>
        <td width="453">
            <p>
                {{$pay->package}}
            </p>
        </td>
        <td width="123">
            <p id="price" >
                @foreach(\App\Models\Packages::all() as $a)
                    @if($a->title == $pay->package)
                        {{$a->price}}
                    @endif

                @endforeach
            </p>
        </td>

    </tr>
    @if($pay->status == 'sponsorship')
    <tr>
        <td width="453">
            <p>
                30 Days Sponsorship
            </p>
        </td>
        <td width="123">
            <p id="price" >
                99
            </p>
        </td>


    </tr>
    @endif

    </tbody>
</table>
<table  >
    <tbody>

    <tr>

        <td width="453" valign="top">
            <p style="width: 100%; text-align: right">
                <strong>TOTAL &nbsp;&nbsp;&nbsp;</strong>
            </p>
        </td>
        <td width="123" valign="top">
            <p id="total">
                    {{$pay->amount }}





            </p>

        </td>
    </tr>

    </tbody>
</table>
<br/>
<hr color="black">
<br/>
<p>
    <br clear="all"/>
    Make all checks payable to Oz Property Market
</p>
<p>
    If you have any questions concerning this invoice, contact Name, Phone,
    Email
</p>
<p style="text-align: center; font-weight: bold;">
    Thank you for choosing Oz Property Market
</p>


</body>
</html>
