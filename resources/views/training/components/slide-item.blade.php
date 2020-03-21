<div class="carousel-item">
    <div class="container-cards-overlay">
        <div class="container-cards">
            <div class="card-hover">
                <div class="face face1">
                    <div class="content">
                        <p>{{$flashcard->getShowText()}}</p>
                    </div>
                </div>
                <div class="face face2">
                    <div class="content">
                        <p>{{$flashcard->getHiddenText()}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
