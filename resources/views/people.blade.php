<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 each-connection">
    <div class="connection-container">
        <?php
            $res = \App\Connection::where('u_id',$userId)->where('connect_with', $person->id)->get();
            $isConnected = count($res) == 1;
        ?>
        @if($isConnected)
            <div id="action{{$person->id}}" class="connection-action" onclick="changeConnection('end', '{{$person->id}}')">&times;</div>
        @else
            <div id="action{{$person->id}}" class="connection-action" onclick="changeConnection('add', '{{$person->id}}')">+</div>
        @endif
        <div class="connection-profile profile-preview" style="background-image: url('{{asset($person->profile)}}')">
        </div>
        <div class="connection-text">
            <div class="connection-name">
                {{$person->username}}
            </div>
            <div class="connection-description">
                <?php
                    $desc = str_replace('<div>', '', $person->description);
                    $desc = str_replace('</div>', '', $desc);
                    $desc = str_replace('<br>', '', $desc);
                ?>
                {{substr($desc, 0, 20).(strlen($desc)>20?'...':'')}}
            </div>
        </div>
    </div>
</div>