<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
    <div class="carousel-inner">
        @foreach($deck->flashcards as $flashcard)
            <div class="carousel-item">
                <div class="container-cards-overlay">
                    <div class="container-cards">
                        <div class="card-hover">
                            <div class="face face1">
                                <div class="content">
                                    <p>{{$flashcard->front_text}}</p>
                                </div>
                            </div>
                            <div class="face face2">
                                <div class="content">
                                    <p>{{$flashcard->back_text}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
