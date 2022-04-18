@extends('layouts.app')
{{--@section('crm-init')--}}
{{--    <a href="{{ route('roles.index') }}">Role</a>--}}
{{--    <init-app></init-app>--}}
{{--@endsection--}}
@section('content')
<div class="bg-secondary">
    <span class="hello-icon">hello icon</span>
    <router-link to="/">Go Home</router-link>
     <div class="clearfix mhl ptl">
    <h1 class="mvm mtn fgc1">Grid Size: Unknown</h1>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-send"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
            <span class="mls"> icon-send</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e900" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe900;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-gallery"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
            <span class="mls"> icon-gallery</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e903" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe903;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
            <span class="mls"> icon-messages2</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e906" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe906;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-pdf"></span>
            <span class="mls"> icon-pdf</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e90b" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe90b;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-people"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></span>
            <span class="mls"> icon-people</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e90c" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe90c;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-arrow-right"></span>
            <span class="mls"> icon-arrow-right</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e912" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe912;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-close-circle"><span class="path1"></span><span class="path2"></span></span>
            <span class="mls"> icon-close-circle</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e913" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe913;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-plus"></span>
            <span class="mls"> icon-plus</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e915" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe915;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-arrow-down"></span>
            <span class="mls"> icon-arrow-down</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e916" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe916;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-edit"><span class="path1"></span><span class="path2"></span></span>
            <span class="mls"> icon-edit</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e917" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe917;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-arrow-bottom"></span>
            <span class="mls"> icon-arrow-bottom</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e919" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe919;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
            <span class="mls"> icon-eye</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e91a" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe91a;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-calendar"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></span>
            <span class="mls"> icon-calendar</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e91c" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe91c;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-maps"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
            <span class="mls"> icon-maps</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e924" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe924;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-notification"></span>
            <span class="mls"> icon-notification</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e929" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe929;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-messages"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
            <span class="mls"> icon-messages</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e92a" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe92a;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-profile-circle"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
            <span class="mls"> icon-profile-circle</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e92d" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe92d;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-note"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
            <span class="mls"> icon-note</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e930" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe930;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-ranking"></span>
            <span class="mls"> icon-ranking</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e934" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe934;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-invoice"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
            <span class="mls"> icon-invoice</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e935" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe935;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-user"><span class="path1"></span><span class="path2"></span></span>
            <span class="mls"> icon-user</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e939" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe939;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-client"><span class="path1"></span><span class="path2"></span></span>
            <span class="mls"> icon-client</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e93b" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe93b;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-call"><span class="path1"></span><span class="path2"></span></span>
            <span class="mls"> icon-call</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e93d" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe93d;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-order"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
            <span class="mls"> icon-order</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e93f" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe93f;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
    <div class="glyph fs1">
        <div class="clearfix bshadow0 pbs fs-1">
            <span class="icon-dashboard"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
            <span class="mls"> icon-dashboard</span>
        </div>
        <fieldset class="fs0 size1of1 clearfix hidden-false">
            <input type="text" readonly value="e942" class="unit size1of2" />
            <input type="text" maxlength="1" readonly value="&#xe942;" class="unitRight size1of2 talign-right" />
        </fieldset>
        <div class="fs0 bshadow0 clearfix hidden-true">
            <span class="unit pvs fgc1">liga: </span>
            <input type="text" readonly value="" class="liga unitRight" />
        </div>
    </div>
</div>
</div>
@endsection
