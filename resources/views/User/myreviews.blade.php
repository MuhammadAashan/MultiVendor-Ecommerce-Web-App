@extends('User.masteruser')
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ url('user/dashboard') }}">Home</a></li>
                    <li class="active">My reviews</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-10 offset-1">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4>My Reviews</h4>
                        <div class="table-responsive">
                            <table class="table table-hover table-tranparent">
                                <thead>
                                </thead>
                                <tbody>
                                    @if (count($reviews) > 0)
                                        @foreach ($reviews as $item)
                                            <tr>
                                                <td>
                                                    <a href="{{ url('user/productdetail/' . $item->ID) }}">
                                                        <img width="100px"
                                                            src="{{ asset('storage/' . $item->CoverImage) }}"
                                                            alt="{{ $item->CoverImage }}" class="img-fluid">
                                                    </a>
                                                </td>
                                                <td>Product Name:{{ $item->Name }}</td>
                                                <td>RS: {{ $item->Price }}</td>
                                                <td>
                                                    <div class="rating-box ">
                                                    <ul class="rating rating-with-review-item">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $item->Rating)
                                                                <li><i class="fa fa-star"></i></li>
                                                            @elseif(empty($item->Rating))
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @else
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @endif
                                                        @endfor
                                                        @if (empty($item->Rating))
                                                            <li>
                                                                <p>(0)</p>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <p>({{ $item->Rating }})</p>
                                                            </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                                <p>Feedback : {{ $item->Feedback }}</p>
                                               </td>

                                                <td>Review Date: {{ strftime('%Y-%B-%d', strtotime($item->Order_Date)) }}</td>


                                            </tr>
                                        @endforeach
                                    @else
                                        <div class="text-center">
                                            <h4>
                                                No Reviews found!
                                            </h4>
                                            <p>To Give Reviews on product goto my order and give review on delivered
                                                products</p>
                                        </div>
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
