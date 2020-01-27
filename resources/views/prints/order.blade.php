@extends('prints.template')
@section('body_content')

    <table border="0" class="table table-condensed table-bordered">
        @include('prints.orders.company')
    </table>

    <table border="0" class="table table-condensed table-bordered">
        <tr>
            <td>
                <table border="0" class="table table-condensed table-bordered">
	                <?php $client = $Order->client; ?>
                    @include('prints.orders.client')
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" class="table table-condensed table-bordered">
                    @include('prints.orders.header')
                </table>
            </td>
        </tr>
    </table>

    <table border="0" class="table table-condensed table-bordered">

        @foreach($Order->apparatus  as $Apparatu)
            @include('prints.orders.apparatu')
        @endforeach

    </table>

    <table border="0" class="table table-condensed table-bordered">
        <tr>
            <td>
                <table border="0" class="table table-condensed table-bordered">
                    @include('prints.orders.closure')
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" class="table table-condensed table-bordered">
                    @include('prints.orders.terms')
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" class="table table-condensed table-bordered">
                    @include('prints.orders.signature')
                </table>
            </td>
        </tr>
    </table>

@endsection