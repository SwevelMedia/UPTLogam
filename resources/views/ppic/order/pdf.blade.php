<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <style>
        html {
            margin-top: 0.2in !important;
            margin-left: 0.2in !important;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 13px;
            line-height: 1.4em;
            font-weight: bold;
        }

        .ticket {
            width: 8in;
            height: 2.7in;
            background-size: cover;
            background-repeat: no-repeat;
            position: relative;
            margin-bottom: 0.2in;
        }

        .ticket-img {
            max-width: 100%;
            height: auto;
            position: relative;
            /*display: inline-block;*/
        }

        #event-info {
            display: inline-block;
            position: absolute;
            left: 0.9in;
            top: 0.12in;
            width: 4.7in;
        }

        .label {
            color: #768690;
            display: block;
            text-transform: uppercase;
        }

        .value {
            display: block;
            color: #121212;
            text-transform: uppercase;
            overflow: hidden;
            font-size: 16px;
        }

        #title {
            height: 0.4in;
        }

        #location {
            height: 0.8in;
        }

        #stub-info {
            display: block;
            position: absolute;
            top: 0.06in;
            left: 6in;
            width: 1.9in;
            text-align: center;
        }

        #purchased-on {
            display: inline-block;
            color: #fff;
            text-transform: uppercase;
            font-size: 9px;
            text-align: center;
            width: 100%;
            position: relative;
        }

        #qrcode {
            position: relative;
            width: 70%;
            height: auto;
            margin-top: 0.3in;
            margin-left: -1.9in;
        }

        #ticket-num {
            display: block;
            text-transform: uppercase;
            text-align: center;
            width: 100%;
            position: relative;
            top: 0;
            left: 0;
            font-weight: bold;
            font-size: 12px;
        }

        #attendee-info {
            text-align: left;
            font-size: 10px;
            position: relative;
            top: 0.18in;
            line-height: 1.6em;
        }

        #attendee-info .value {
            font-size: 10px;
        }

            {
            # Annoying alignedment issues when rending in PDF #
        }

            {
            % if craft.app.request.getParam('format')=='plain' %
        }

        #purchased-on {
            display: block;
        }

        #qrcode {
            display: inline;
            margin: 15 0 0 0;
        }

            {
            % endif %
        }
    </style>
</head>

<body>
    <div class="ticket bg-white">
        <img class="ticket-img" src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" />

        <div id="event-info">
            <span class="label">Nama Project</span>
            <span id="title" class="value">{{ $order->order_name }}</span>

            <span class="label">Nomor Pesanan</span>
            <span class="value">{{ $order->order_number }}</span>

            <span class="label">Nama Perusahaan</span>
            <span class="value">{{ $order->client->name }}</span>

            <span class="label">Material</span>
            <span class="value">
                @foreach ($order->materialOrders as $materialOrder)
                    {{ $materialOrder->material->name }}
                    @if ($loop->last)
                    @else
                        ,
                    @endif
                @endforeach
            </span>

            <span class="label">Mesin</span>
            <span class="value">
                @foreach ($order->machineOrders as $machineOrder)
                    @if ($loop->iteration <= 3)
                        {{ $machineOrder->mesin->name }} @if ($loop->last)
                        @else
                            ,
                        @endif
                    @else
                        @if ($loop->last)
                            dst
                        @endif
                    @endif
                @endforeach
            </span>
        </div>

        <div id="stub-info">
            <span id="purchased-on">Waktu pesanan {{ $order->created_at->format('d M Y') }}</span>

            <img id="qrcode" src="data:image/png;base64, {!! $qrcode !!}" />

        </div>
    </div>
</body>

</html>
