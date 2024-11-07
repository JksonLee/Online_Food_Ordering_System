@extends('FrontEnd.master')
@section('title')
    Dishes
@endsection

@section('content')

<!-- CSS for Star Rating -->
<style>
    
    .details-label {
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 10px;
    color: #333;
}

.single-price-text {
    font-size: 14px;
    line-height: 1.5;
    color: #555;
}

    
.custom-quantity-input {
    width: 80px;
    padding: 5px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.12);
    transition: border-color 0.3s, box-shadow 0.3s;
}

.custom-quantity-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.quantity-input {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.quantity-input label {
    font-size: 14px;
    font-weight: 500;
    color: #333;
    margin-right: 10px;
}

    
/*   .ratings-reviews {
    width: 100%;  Adjust if necessary 
    text-align: left;
    margin-top: 20px;
    margin-left:-400px;
}

.review {
    margin-left: 0;  Makes the individual reviews aligned to the left 
}*/


.average-rating {
    font-size: 2rem; /* Increase the font size */
    font-family: 'Arial', sans-serif; /* Change the font family */
    font-weight: bold;
    color: #333;
}

.reviews-header {
    font-size: 1.8rem; /* Increase the font size */
    font-family: 'Arial', sans-serif; /* Change the font family */
    font-weight: bold;
    color: #333;
}


   /* Container for the reviews */
    .review-container {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        border-radius: 5px;
        margin-bottom: 20px;
        margin-left:-370px;
    }

    /* Customer information */
    .review-customer {
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
         font-size: 1.9rem; /* Increase font size for the review text */
       
    }

    /* Rating section */
    .review-rating {
        display: inline-block;
        color: #f8ce0b; /* Star color */
        margin-bottom: 10px;
         font-size: 2.5rem; /* Increase font size for the review text */
    }

   .review-text {
    font-style: italic;
    color: #555;
    font-size: 1.9rem; /* Increase font size for the review text */
}
    
   .star-rating {
        font-size: 2rem;
        color: #ffdd57;
        cursor: pointer;
    }

    .star {
        color: #ddd;
    }

    .star.selected {
        color: #ffdd57;
    }
    


/* Filled stars for ratings */
.star.filled {
    color: #ffdd57; /* Yellow for filled stars */
}
    
      /* Container for review section */
    .reviews-container {
        margin-top: 30px;
    }

    /* Styling for the review form */
    .review-form-container {
        background-color: #f2f2f2;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        margin-left:-370px;
    }

    .review-form label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .review-form textarea {
        width: 100%;
        border-radius: 5px;
        padding: 10px;
        border: 1px solid #ddd;
        margin-bottom: 10px;
    }

    .review-form button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .review-form button:hover {
        background-color: #0056b3;
    }
    
</style>



<!-- products -->
    <div class="products">    
        <div class="container">
            <div class="col-md-9 product-w3ls-right"> 
                <div class="product-top">
                    <h4>Food Collection</h4>
                    <div class="clearfix"> </div>
                </div>
                <div class="products-row">

                    <!-- Display Filtered Dishes -->
                    @if($filteredDishes->count() > 0)
                        @foreach($filteredDishes as $dish)
                            <div class="col-xs-6 col-sm-4 product-grids">
                                <div class="flip-container">
                                    <div class="flipper agile-products">
                                        <div class="front"> 
                                            <img src="{{ asset($dish->dish_image)}}" style="height:182px;width:277px;" class="img-responsive" alt="img">
                                            <div class="agile-product-text">              
                                                <h5>{{ $dish->dish_name }}</h5>  
                                            </div> 
                                        </div>
                                        <div class="back">
                                            <h4>{{ $dish->dish_name }}</h4>
                                            <p>{{ $dish->dish_detail }}</p>
                                            <h6><sup>RM</sup>{{ $dish->full_price }}</h6>
                                            @if($dish->half_price != null)
                                                <h6><sup>Half-RM</sup>{{ $dish->half_price }}</h6>
                                            @endif
                                            
                                            <form action="{{ route('cart.add') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="dish_id" value="{{ $dish->dish_id }}"> 
                                                <a href="#" data-toggle="modal" data-target="#myModal1{{ $dish->dish_id }}">
                                                    More <span class="w3-agile-line"></span><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </div> 
                            </div> 

                            <!-- modal -->
                            <div class="modal video-modal fade" id="myModal1{{ $dish->dish_id }}" tabindex="-1" role="dialog" aria-labelledby="myModal1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>                        
                                        </div>
                                        <section>
                                            <div class="modal-body">
                                                <div class="col-md-5 modal_body_left">
                                                    <img src="{{ asset($dish->dish_image) }}" style="height:450px;width:1000px;" alt=" " class="img-responsive">
                                                </div>
                                                <div class="col-md-7 modal_body_right single-top-right"> 
                                                    <h3 class="item_name">{{ $dish->dish_name }}</h3>
                                                    <p>{{ $dish->dish_detail }}</p>
                                                     <!-- Display dynamic rating stars -->
                            <div class="single-rating">
                         <ul class="rating-stars">
                        @php
                     $averageRating = $dish->ratings->avg('rating');
            @endphp
            
            <!-- Loop through to display filled stars based on average rating -->
            @for ($i = 1; $i <= 5; $i++)
                @if($i <= $averageRating)
                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                @else
                    <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                @endif
            @endfor

            <!-- Display review count -->
            <li class="rating">{{ $dish->ratings->count() }} reviews</li>
            <li><a href="#">Add your review</a></li>
        </ul>
    </div>
                                                    <div class="single-price">
                                                        <ul>
                                                            <li><h2 style="color:black;">Full Price:</h4>RM{{ $dish->full_price }}</li>
                                                          
                                                                                          <li>
 <a href="#" data-toggle="modal" data-target="#couponModal{{ $dish->dish_id }}">
    <i class="fa fa-gift" aria-hidden="true"></i> Coupon
</a>
</li>


<div class="modal fade" id="couponModal{{ $dish->dish_id }}" tabindex="-1" role="dialog" aria-labelledby="couponModalLabel{{ $dish->dish_id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="couponModalLabel">Coupon Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($coupons->count() > 0)
                    @foreach($coupons as $coupon)
                        <div class="coupon-details">
                            <div class="coupon-section">
                                <span class="coupon-label">Coupon Code:</span>
                                <span class="coupon-value">{{ $coupon->coupon_code }}</span>
                            </div>
                            <div class="coupon-section">
                                <span class="coupon-label">Discount Type:</span>
                                <span class="coupon-value">
                                    @if($coupon->coupon_type == 1) <!-- Percentage discount -->
                                        {{ $coupon->coupon_value }}%
                                    @else <!-- Fixed amount discount -->
                                        RM{{ $coupon->coupon_value }}
                                    @endif
                                </span>
                            </div>
                            <div class="coupon-section">
                                <span class="coupon-label">Minimum Cart Value:</span>
                                <span class="coupon-value">RM{{ $coupon->cart_min_value }}</span>
                            </div>
                            <div class="coupon-section">
                                <span class="coupon-label">Expires On:</span>
                                <span class="coupon-value">{{ \Carbon\Carbon::parse($coupon->expired_on)->format('Y-m-d') }}</span>
                            </div>

                            <!-- Check if coupon is expired -->
                            @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($coupon->expired_on)))
                                <p style="color: red; font-weight: bold;">This coupon is expired, not able to use.</p>
                                <button type="button" class="btn btn-danger" disabled>Disable Use</button>
                            @else
                                <!-- Apply Coupon Form -->
                                <form action="{{ route('apply.coupon') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="coupon_code">Enter Coupon Code:</label>
                                        <input type="text" name="coupon_code" id="coupon_code" class="form-control" value="{{ $coupon->coupon_code }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Apply Coupon</button>
                                </form>
                            @endif
                        </div>
                        <hr />
                    @endforeach
                @else
                    <p>No Coupons Available</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

                                                        </ul>    
                                                    </div> 
                                                     <hr><br>
                                                  <div class="dish-details">
    <h4 class="details-label">Details:</h4>
    <p class="single-price-text">{{ $dish->dish_detail }}</p>
</div>
                                                    <form action="{{ route('cart.add') }}" method="post">
                                                        @csrf    
                                                        <input type="hidden" name="dish_id" value="{{ $dish->dish_id }}" />
                                                      <!-- Quantity Input with Increment/Decrement -->
<!-- Quantity Input Field -->
<div class="quantity-input">
    <label for="quantity" class="mr-2">Quantity:</label>
    <input type="number" id="quantity" name="qty" min="1" value="1" class="form-control custom-quantity-input" />
</div>

                                                        <button type="submit" class="w3ls-cart pw3ls-cart">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                                            Add to cart
                                                        </button>
                                                    </form>
                                                    
                                              <form action="{{ route('wishlist.add', ['dish_id' => $dish->dish_id]) }}" method="post">
                                                 @csrf
                                                      <button type="submit" class="btn btn-primary">Add to Wishlist</button>
                                                   </form>
                                                   
                                                    <br><br><br>  <hr>
                                                    
                                                   <!-- Rating and Reviews Section -->
<div class="ratings-reviews">
     <h5 class="average-rating">Average Rating: 
        @php
            $averageRating = $dish->ratings->avg('rating');
        @endphp
        {{ number_format($averageRating, 1) }} ★
    </h5>


    <h5 class="reviews-header">Reviews</h5>
<div class="reviews-container">
    <!-- Displaying each review -->
    @foreach($dish->ratings as $rating)
        <div class="review-container">
            <div class="review-customer">
                <p><strong>Customer:</strong> {{ $rating->customer ? $rating->customer->email : 'Unknown' }}</p>
            </div>

            <div class="review-rating">
                <strong>Rating:</strong>
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $rating->rating ? 'filled' : '' }}">★</span>
                    @endfor
                       <span style="margin-left: 10px;">{{ $rating->rating }} / 5</span>
                </div>
              
            </div>

            <div class="review-text">
                <p><strong>Review:</strong> {{ $rating->review }}</p>
            </div>
        </div>
    @endforeach
</div>

<!-- Review Form -->
<div class="review-form-container">
    <h4>Give your review and rating</h4>
    <form action="{{ route('submit.rating', ['dish_id' => $dish->dish_id]) }}" method="POST">
        @csrf
        <div class="star-rating" style=" font-size: 2.5rem; /* Increase font size for the review text */"id="star-rating-{{ $dish->dish_id }}">
            <span class="star" data-value="5" onclick="selectStar({{ $dish->dish_id }}, 5)">★</span>
            <span class="star" data-value="4" onclick="selectStar({{ $dish->dish_id }}, 4)">★</span>
            <span class="star" data-value="3" onclick="selectStar({{ $dish->dish_id }}, 3)">★</span>
            <span class="star" data-value="2" onclick="selectStar({{ $dish->dish_id }}, 2)">★</span>
            <span class="star" data-value="1" onclick="selectStar({{ $dish->dish_id }}, 1)">★</span>
            <input type="hidden" name="rating" id="rating-value-{{ $dish->dish_id }}" value="1">
        </div>

        <div class="form-group">
            <label for="review">Your Review:</label>
            <textarea class="form-control" id="review" name="review" rows="4" required></textarea>
        </div>

        <button type="submit"   class="btn btn-primary">Submit</button>
    </form>
</div>


</div>






                        
                        
                                                    <div class="single-page-icons social-icons"> 
                                                        <ul>
                                                            <li><h4>Share on</h4></li>
                                                            <li><a href="#" class="fa fa-facebook icon facebook"> </a></li>
                                                            <li><a href="#" class="fa fa-twitter icon twitter"> </a></li>
                                                            <li><a href="#" class="fa fa-google-plus icon googleplus"> </a></li>
                                                            <li><a href="#" class="fa fa-dribbble icon dribbble"> </a></li>
                                                            <li><a href="#" class="fa fa-rss icon rss"> </a></li> 
                                                        </ul>
                                                    </div> 
                                                </div> 
                                                <div class="clearfix"> </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div> 
                            <!-- //modal -->

                            
                            
                            
                        @endforeach
                    @else
                        <p>No dishes found matching your criteria.</p>
                    @endif

                    <div class="clearfix"> </div>
                </div>
            </div>

            <div class="col-md-3 rsidebar">
                <div class="rsidebar-top">
                    <form action="{{ route('search') }}" method="GET" class="search-form">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" placeholder="Search by item name or category" required>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </span>
                        </div>
                    </form>

                    <!-- Add Filters Below -->
              <div class="filter-section" style="margin-top: 20px;">
    <h4>Filter by:</h4>
    <form action="{{ route('search') }}" method="GET">
        <!-- Categories Filter -->
        <label for="category">Category:</label>
        <select name="category" id="category" class="form-control">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->category_id }}" 
                        {{ request('category') == $category->category_id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select>

        <!-- Price Range Filter -->
        <label for="price_range" style="margin-top: 10px;">Price Range:</label>
        <select name="price_range" id="price_range" class="form-control">
            <option value="">All Prices</option>
            <option value="low" {{ request('price_range') == 'low' ? 'selected' : '' }}>RM0 - RM10</option>
            <option value="mid" {{ request('price_range') == 'mid' ? 'selected' : '' }}>RM11 - RM30</option>
            <option value="high" {{ request('price_range') == 'high' ? 'selected' : '' }}>RM31 and above</option>
        </select>

        <!-- Rating Filter -->
        <label for="rating" style="margin-top: 10px;">Rating:</label>
        <select name="rating" id="rating" class="form-control">
            <option value="">All Ratings</option>
            <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>5 Stars</option>
            <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>4 Stars & above</option>
            <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>3 Stars & above</option>
            <option value="2" {{ request('rating') == 2 ? 'selected' : '' }}>2 Stars & above</option>
            <option value="1" {{ request('rating') == 1 ? 'selected' : '' }}>1 Star & above</option>
        </select>

        <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Apply Filter</button>
            <a href="{{ route('search') }}" class="btn btn-primary" style="margin-top: 15px;">Reset Filter</a>
    </form>
</div>

                    <div class="slider-left">
                        <h4>Categories</h4>            
                        <div class="row row1 scroll-pane">
                            @foreach($categories as $category)
                                <label class="checkbox">
                                    <a href="{{ route('category_dish', ['category_id' => $category->category_id]) }}">
                                        {{ $category->category_name }}
                                    </a>
                                </label>
                            @endforeach        
                        </div> 
                    </div>
                </div>
                <div class="clearfix"> </div> 
            </div>
        </div>
    </div>
            
    <br>
    
    <!-- //products --> 
    <div class="container"> 
        <div class="w3agile-deals prds-w3text"> 
            <h5>Vestibulum maximus quam et quam egestas imperdiet. In dignissim auctor viverra.</h5>
        </div>
    </div>
@endsection

<script>
 
    
    function selectStar(dishId, value) {
        const stars = document.querySelectorAll(`#star-rating-${dishId} .star`);
        const ratingInput = document.getElementById(`rating-value-${dishId}`);

        // Reset all stars
        stars.forEach(star => star.classList.remove('selected'));

        // Highlight the selected stars and all stars before it
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= value) {
                star.classList.add('selected');
            }
        });

        // Set the selected value to the hidden input
        ratingInput.value = value;
    }
</script>