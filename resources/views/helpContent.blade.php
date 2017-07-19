<div class="top-margin"></div>
<div class="container" style="text-align: center; font-family: raleway; font-size: 30px;">
    <div class="row">
        <h1 style="font-weight: bolder; color: black">
            FAQ
        </h1>
    </div>
    <div>
        @foreach($questions as $question)
            <div class="panel panel-primary" style="width: 90%; margin: 30px;">
                <div class="panel-heading">
                    <h3 class="panel-title" style="font-weight: bolder">
                        {{ $question->question }}
                    </h3>
                </div>
                <div class="panel-body">
                    <p style='font-size: 15px; font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif'>
                        {!! $question->answer !!}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>