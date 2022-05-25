<html>
<head>
    <style>
        body{
            background: #c6c6c6;
        }

        #pricing-table {
        /*margin: 100px auto;*/
            text-align: center;
            width: 100%;
            padding: 20px;
        /*width: 892px;  total computed width = 222 x 3 + 226 */
        }

        #pricing-table .plan {
            font: 12px 'Lucida Sans', 'trebuchet MS', Arial, Helvetica;
            text-shadow: 0 1px rgba(255,255,255,.8);
            background: #fff;
            border: 1px solid #ddd;
            color: #333;
            padding: 20px;
            margin:0.5%;
            margin-top:50px;
        //width: 180px; /* plan width = 180 + 20 + 20 + 1 + 1 = 222px */
            float: left;
        //width: 16%;
            display:inline-block;
            position: relative;
            -moz-border-radius: 5px 5px 5px 5px;
            -webkit-border-radius: 5px 5px 5px 5px;
            border-radius: 5px 5px 5px 5px;
            box-shadow: 0px 0px 7px red;
        }

        #pricing-table #most-popular {
            z-index: 2;
            top: -13px;
            border-width: 3px;
            padding: 30px 20px;
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
            border-radius: 5px;
        //-moz-box-shadow: 20px 0 10px -10px rgba(0, 0, 0, .15), -20px 0 10px -10px rgba(0, 0, 0, .15);
        //-webkit-box-shadow: 20px 0 10px -10px rgba(0, 0, 0, .15), -20px 0 10px -10px rgba(0, 0, 0, .15);
        //box-shadow: 20px 0 10px -10px rgba(0, 0, 0, .15), -20px 0 10px -10px rgba(0, 0, 0, .15);
            overflow: hidden;
        }

        #pricing-table #most-popular .popular{
            position: absolute;
            transform: translate(-40%, -25%) rotate(-45deg);
            color: yellow;
            background: #e4002b;
            /* height: 100; */
            /* width: 150px; */
            padding: 15px;
            padding-right: 60px;
            padding-left: 60px;
        }


        .ss{
            margin-left: 50%;
            transform: translateX(-50%);}




        /* --------------- */

        #pricing-table h3 {
            font-size: 20px;
            font-weight: normal;
            padding: 20px;
            margin: -20px -20px 50px -20px;
            background-color: #eee;
            background-image: -moz-linear-gradient(#fff,#eee);
            background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#eee));
            background-image: -webkit-linear-gradient(#fff, #eee);
            background-image: -o-linear-gradient(#fff, #eee);
            background-image: -ms-linear-gradient(#fff, #eee);
            background-image: linear-gradient(#fff, #eee);
        }

        #pricing-table #most-popular h3 {
            background-color: #ddd;
            background-image: -moz-linear-gradient(#eee,#ddd);
            background-image: -webkit-gradient(linear, left top, left bottom, from(#eee), to(#ddd));
            background-image: -webkit-linear-gradient(#eee, #ddd);
            background-image: -o-linear-gradient(#eee, #ddd);
            background-image: -ms-linear-gradient(#eee, #ddd);
            background-image: linear-gradient(#eee, #ddd);
            margin-top: -30px;
            padding-top: 30px;
            -moz-border-radius: 5px 5px 0 0;
            -webkit-border-radius: 5px 5px 0 0;
            border-radius: 5px 5px 0 0;
        }

        #pricing-table .plan:nth-child(1) h3 {
            -moz-border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            border-radius: 5px 0 0 0;
        }

        #pricing-table .plan:nth-child(4) h3 {
            -moz-border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            border-radius: 0 5px 0 0;
        }

        #pricing-table h3 span {
            display: block;
            font: bold 25px/100px Georgia, Serif;
            color: #777;
            background: #fff;
            border: 5px solid #fff;
            height: 100px;
            width: 100px;
            margin: 10px auto -65px;
            -moz-border-radius: 100px;
            -webkit-border-radius: 100px;
            border-radius: 100px;
            -moz-box-shadow: 0 5px 20px #ddd inset, 0 3px 0 #999 inset;
            -webkit-box-shadow: 0 5px 20px #ddd inset, 0 3px 0 #999 inset;
            box-shadow: 0 5px 20px #ddd inset, 0 3px 0 #999 inset;
        }

        /* --------------- */

        #pricing-table ul {
            margin: 20px 0 0 0;
            padding: 0;
            list-style: none;
        }

        #pricing-table li {
            border-top: 1px solid #ddd;
            padding: 10px 0;
        }

        /* --------------- */

        #pricing-table .signup {
            position: relative;
            padding: 8px 20px;
            margin: 20px 0 0 0;
            color: #fff;
            font: bold 14px Arial, Helvetica;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
            background-color: #e4002b;
            background-image: -moz-linear-gradient(#ab0020, #e4002b);
            background-image: -webkit-gradient(linear, left top, left bottom, from(#ab0020), to(#e4002b));
            background-image: -webkit-linear-gradient(#ab0020, #e4002b);
            background-image: -o-linear-gradient(#ab0020, #e4002b);
            background-image: -ms-linear-gradient(#ab0020, #e4002b);
            background-image: linear-gradient(#ab0020, #e4002b);
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            text-shadow: 0 1px 0 rgba(0,0,0,.3);
            -moz-box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
            -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
            box-shadow: 0 1px 0 rgba(255, 255, 255, .5), 0 2px 0 rgba(0, 0, 0, .7);
        }

        #pricing-table .signup:hover {
            background-color: #e4002b;
            background-image: -moz-linear-gradient(#ff224b, #e4002b);
            background-image: -webkit-gradient(linear, left top, left bottom, from(#ff224b), to(#e4002b));
            background-image: -webkit-linear-gradient(#ff224b, #e4002b);
            background-image: -o-linear-gradient(#ff224b, #e4002b);
            background-image: -ms-linear-gradient(#ff224b, #e4002b);
            background-image: linear-gradient(#ff224b, #e4002b);
        }

        #pricing-table .signup:active, #pricing-table .signup:focus {
            background: #e4002b;
            top: 2px;
            -moz-box-shadow: 0 0 3px rgba(0, 0, 0, .7) inset;
            -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, .7) inset;
            box-shadow: 0 0 3px rgba(0, 0, 0, .7) inset;
        }

        /* --------------- */

        .clear:before, .clear:after {
            content:"";
            display:table
        }

        .clear:after {
            clear:both
        }

        .clear {
            zoom:1
        }
    </style>

</head>

<body>
<div id="pricing-table" class="clear">
    <h1>Residential Sale Packages</h1>
    <center>
        <div class="plan">
            <h3>Basic<span>$99</span></h3>
            <a class="signup" href="/pricing#Residential_Sale">More Details</a>
            <ul>
                <li><b></b> Property Brochures</li>
                <li><b></b> Buyer Enquiry Forwarding</li>
                <li><b></b>Manage and edit your Listing 24/7</li>
                <li><b></b>Attach your own Floor Plan</li>
            </ul>
        </div>
        <div class="plan">
            <h3>Professional<span>$590</span></h3>
            <a class="signup" href="/pricing#Residential_Sale">More Details</a>
            <ul>
                <li><b></b> Property Brochures</li>
                <li><b></b>Manage and edit your Listing 24/7</li>
                <li><b></b>Attach your own Floor Plan</li>
                <li><b></b>Attach your video to your Listing</li>
            </ul>
        </div>
        <div class="plan">
            <h3>Gold<span>$690</span></h3>
            <a class="signup" href="/pricing#Residential_Sale">More Details</a>
            <ul>

                <li><b></b>Manage and edit your Listing 24/7</li>
                <li><b></b>Attach your own Floor Plan</li>
                <li><b></b>Attach your video to your Listing</li>
                <li><b></b>Open for inspection flag</li>
            </ul>
        </div>

        <div class="plan" id="most-popular">
            <p class="popular"> POPULAR</p>
            <h3>Platinum<span>$1490</span></h3>
            <a class="signup" href="/pricing#Residential_Sale">More Details</a>
            <ul>
                <li><b></b>Manage and edit your Listing 24/7</li>
                <li><b></b>Attach your video to your Listing</li>
                <li><b></b>Open for inspection flag</li>
                <li><b></b>'SOLD' sticker and zipped ties</li>
            </ul>
        </div>
        <div class="plan">
            <h3>Ultimate<span>$2490</span></h3>
            <a class="signup" href="/pricing#Residential_Sale">More Details</a>
            <ul>
                <li><b></b> Property Brochures</li>
                <li><b></b>Open For Inspection Flags</li>
                <li><b></b>For Sale sign board</li>

                <li><b></b>Social Media  Advertisement</li>
            </ul>
        </div>
    </center>
</div>

<div id="pricing-table" class="clear">
    <h1>Residential Rental Packages</h1>
    <div class="plan">
        <h3>Standard<span>$69</span></h3>
        <a class="signup" href="/pricing#Residential_Rent">More Details</a>
        <ul>
            <li><b></b>Manage and edit your Listing 24/7</li>
            <li><b></b> 'For Lease' Board</li>
            <li><b></b>Fully Signed PDF Applications</li>
            <li><b></b> Extended Customer Support</li>
        </ul>
    </div>
    <div class="plan" id="most-popular">
        <p class="popular"> POPULAR</p>
        <h3>Professional<span>$199</span></h3>
        <a class="signup" href="/pricing#Residential_Rent">More Details</a>
        <ul>
            <li><b></b>Manage and edit your Listing 24/7</li>
            <li><b></b> Extended customer support</li>
            <li><b></b>Fully Signed PDF Applications</li>

            <li><b></b> Listing on domain.com.au</li>
        </ul>
    </div>
</div>

<div id="pricing-table" class="clear">
    <h1>Commercial Sale Packages</h1>
    <div class="plan">
        <h3>Basic<span>$99</span></h3>
        <a class="signup" href="/pricing#Commercial_Sale">More Details</a>
        <ul>
            <li><b></b>Manage and edit your Listing 24/7</li>
            <li><b></b> Printable Brochures</li>
            <li><b></b> Extended customer support</li>
        </ul>
    </div>
    <div class="plan">
        <h3>Gold<span>$390</span></h3>
        <a class="signup" href="/pricing#Commercial_Sale">More Details</a>
        <ul>
            <li><b></b>'For Sale' Board</li>
            <li><b></b> Printable Brochures</li>
            <li><b></b> Manage Your Listing 24/7</li>

        </ul>
    </div>
    <div class="plan" id="most-popular">
        <p class="popular"> POPULAR</p>
        <h3>Professional<span>$790</span></h3>
        <a class="signup" href="/pricing#Commercial_Sale">More Details</a>
        <ul>
            <li><b></b>'For Sale' Board</li>

            <li><b></b> Manage Your Listing 24/7</li>
            <li><b></b> List on commercialrealestate.com.au</li>
        </ul>
    </div>
</div>

<div id="pricing-table" class="clear">
    <h1>Commercial Rental Packages</h1>
    <div class="plan">
        <h3>Basic<span>$99</span></h3>
        <a class="signup" href="/pricing#Commercial_Rent">More Details</a>
        <ul>

            <li><b></b> Extended customer support</li>
            <li><b></b> Printable Brochures</li>
            <li><b></b> Manage Your Listing 24/7</li>
            <li><b></b>Fully Signed PDF Applications</li>
        </ul>
    </div>
    <div class="plan">
        <h3>Gold<span>$199</span></h3>
        <a class="signup" href="/pricing#Commercial_Rent">More Details</a>
        <ul>
            <li><b></b> Extended customer support</li>
            <li><b></b> Printable Brochures</li>
            <li><b></b>'For Lease' Board</li>
            <li><b></b>Fully Signed PDF Applications</li>
        </ul>
    </div>
    <div class="plan" id="most-popular">
        <p class="popular"> POPULAR</p>
        <h3>Professional<span>$399</span></h3>
        <a class="signup" href="/pricing#Commercial_Rent">More Details</a>
        <ul>
            <li><b></b>'For Lease' Board</li>
            <li><b></b> Printable Brochures</li>
            <li><b></b> Manage Your Listing 24/7</li>

            <li><b></b> List on commercialrealestate.com.au</li>
        </ul>
    </div>
</div>

<div id="pricing-table" class="clear">
    <h1>Other Business Packages</h1>
    <div class="plan">
        <h3>Business Sales Package<span>$99</span></h3>
        <a class="signup" href="/pricing#Business_Sale">More Details</a>
        <ul>

            <li><b></b> Printable Brochures</li>
            <li><b></b> Manage Your Listing 24/7</li>

            <li><b></b> Extended Customer Support</li>
        </ul>
    </div>
    <div class="plan"  >
        <h3>Photo Sign Package<span>$799</span></h3>
        <a class="signup" href="/pricing#Business_Sale">More Details</a>
        <ul>
            <li><b></b>Weekly Property Reports</li>
            <li><b></b>1 x large 'SOLD' sticker</li>

            <li><b></b> Manage Your Listing 24/7</li>

        </ul>
    </div>
</div>
</body>
</html>
