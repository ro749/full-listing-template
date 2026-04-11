@if(isset($plans))
<div style="padding-top: 2rem;">
    {!! $plans->render($personal_plan??null,$sender??null) !!}    
</div>
@endif
@if(isset($sender))
<div style="padding-bottom: 2em; padding-top: 1em;">

{!! $sender->render() !!}
@endif