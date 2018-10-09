<div class="row cardMainInfo_mob">
    <div class="col-6">
        <div class="imageContainer" style="padding: 10px;">
            <?
            $photoSrc = $freelancer->userData->photo;
            if(!empty($photoSrc)){
                if ($photoSrc[0] !== '/' && $photoSrc[0] !== 'h') {
                    $photoSrc = '/' . $photoSrc;
                }
            }
            ?>
            <img src="{{$photoSrc}}" alt="freelancer" class="freelancerImg"
                 width="120" height="120">
        </div>
    </div>
    <div class="col-6 resumeCardRight">
        <div class="nameArea">
            <div class="nameCard">
                {{$freelancer->firstName}} {{$freelancer->lastName}}
            </div>
            <div class="jobTitle" style="font-size: 17px; padding-left: 0; color: #c1d1ff" id="animatedText{{$freelancer->id}}{{$value['id']}}">
                {{$freelancer->userData->jobTitle}}
            </div>
            <div  class="text-left" style="font-size: 15px; color: white; padding-top: 5px;" >
                <div class="cardLabel" style="font-weight: normal;">Hourly rate :
                    <span style="font-weight: bold;">
                        ${{intval($freelancer->userData->salary) +5}}
                    </span>
                </div>
            </div>
            <div class="text-left"  style="font-size: 15px; color: white; padding-top: 5px;">
                <div class="cardLabel" style="font-weight: normal;">Availability :  <span id="maxHours{{$freelancer->id}}{{$value['id']}}" style="font-weight: bold;">{{intval($freelancer->userData->availableHours)}}h/week</span></div>
            </div>
            <div id="welcomeText{{$freelancer->id}}{{$value['id']}}" class="d-none">
                Hi, I am {{$freelancer->firstName}}, I am a {{$freelancer->userData->jobTitle}}, How can I help
                you ?
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6" style="margin-top: -39px; padding-left: 28px;">
            <form action="/chat-room/start_conversation" method="post">
                {{csrf_field()}}
                <input type="hidden" name="freelancer_id" value="{{$freelancer->id}}{{$value['id']}}">
                <input type="submit"  value="TAP TO CHAT" class="tap-to-chat cursorPointerOnHover" style="background: none; border:none; outline: none;">
            </form>
        </div>
    </div>

    <div class="col-12" style="padding: 10px 20px 20px 20px;">
        <div class="text-center cardRow NoDecor">
            <a class="hireCardBtn btn-block" href="/stripe/hire?freelancerID={{$freelancer->id}}&hours=10&weeks=4" id="hireMeBtn{{$freelancer->id}}{{$value['id']}}">
                Hire me
            </a>
        </div>
    </div>
</div>

{{-- interviews --}}
<div class="row interviewIcons" style="border-bottom: 1px solid #E6EDEE; padding-bottom: 15px;">
    <div class="col-12 jobTitle text-center" style="color:#4E75E8; padding-top: 8px; padding-bottom: 15px;">
        View interviews
    </div>
    <div class="col-6 audioTransArea text-center NoDecor">
        <a href="javascript:void(0)" id="{{$freelancer->id}}{{$value['id']}}_open_audio" style="outline: none;" class="openAudio">
            <div class="cardIconsCon">
                <span>
                    <img src="/resumeApp/resources/assets/images/audio_blue.png"
                         alt="" style="padding-right: 14px; width: 34px;">
                    <span class="audioText" style="color: #4E75E8;">Audio & Text</span>
                </span>
            </div>
        </a>
    </div>
    <div class="col-6 videoArea NoDecor">
        <a href="javascript:void(0)" id="{{$freelancer->id}}{{$value['id']}}_open_video" style="outline: none;" class="openVideo">
            <div class="cardIconsCon2  text-center">
                <span>
                    <img src="/resumeApp/resources/assets/images/video_blue.png"
                         alt="" style="padding-right: 14px; width: 34px;">
                    <span class="audioText" style="color: #4E75E8;">Video Interview</span>
                </span>
            </div>
        </a>
    </div>
</div>