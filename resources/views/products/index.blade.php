<!-- resources/views/products.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Product Listing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .row>* {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x)/2);
            padding-left: calc(var(--bs-gutter-x)/2);
            margin-top: var(--bs-gutter-y);
        }
        .price-new {
            font-weight: 600;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }
        body {
            font-family: open sans,sans-serif;
            font-weight: 400;
            color: #666;
            font-size: 13px;
            line-height: 20px;
            width: 100%;
        }
    </style>

</head>
<body>
    <h2 style="text-align: center;margin-bottom:25px;">Featured Products</h2>
        <div class="row"  style="padding-left: 25px;width:90%">
            @foreach($products as $prodct)    
                <div class="col">            
                    <div class="product-thumb">
                        <div class="image"><a href="javascript:;" alt="{{$prodct->name}}" title="{{$prodct->name}}" class="img-fluid">
                        <img style="width: 120px;height:120px;" src="https://exquise.anecdote.id/wp-content/uploads/2020/08/Dummy-Product.jpeg" alt="{{$prodct->name}}" title="{{$prodct->name}}" class="img-fluid">
                        </a></div>
                        <div class="content">
                            <div class="description" style="min-height: 225px;">
                                <h4><a href="{{ route('productdetails.show',['id'=>$prodct->id])}}">{{$prodct->name}}</a></h4>
                                <p>{{$prodct->description}}</p>
                                <div class="price">
                                    <span class="price-new">&euro; {{$prodct->price}}</span>
                                </div>
                            </div>
                            <div class="button-group">
                                <button type="button" class="btn btn-primary"><a style="color: #FFF;text-decoration:auto;font-size:medium;padding:2px;" href="{{ route('productdetails.show',['id'=>$prodct->id])}}">Buy Now</a></button>
                            </div>
                        </div>
                    </div>          
                </div>
            @endforeach
        </div>                    
</body>
</html>