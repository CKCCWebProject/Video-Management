<div class="top-margin"></div>
<div class="container question" style="width: 100%; text-align: center; font-family: raleway; font-size: 30px;">
    <div class="row">

        @if(!isset($searchQuestion))
            <h1 style="font-weight: bolder; color: black">
                FAQ
            </h1>
        @else
            <h3>
                <span style="font-weight: bolder">search :</span>
                <span style='font-style: italic; font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif'>{{ $question }}</span>
            </h3>
        @endif

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
    {{ $questions->links() }}
    <div class="row">
        <span style="font-weight: bold">send question to :</span>
        <span style="font-weight: normal; font-style: italic">vdomngmt&#64;gmail.com</span>
    </div>
</div>