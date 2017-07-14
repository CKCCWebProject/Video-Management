<div class="col-lg-4 col-md-4 col-sm-6 col-lg-12 each-connection">
    <div class="connection-container">
        <?php
            $res = \App\Connection::where('u_id',$userId)->where('connectWith', $person->id)->get();
            $isConnected = count($res) == 1;
        ?>
        <div class="connection-action">{{$isConnected?'&times;':'+'}}</div>
        <div class="connection-profile profile-preview" style="background-image: url('{{asset($person->profile)}}')">
        </div>
        <div class="connection-text">
            <div class="connection-name">
                {{$person->username}}
            </div>
            <div class="connection-description">
                {{substr($person->description, 0, 20).(strlen($person->description)>20?'...':'')}}
            </div>
        </div>
    </div>
</div>