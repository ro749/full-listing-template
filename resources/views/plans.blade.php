    @if(isset($plans))
    <div style="padding-top: 2rem;">
        
            {!! $plans->render($personal_plan) !!}
        
</div>
@endif
@if(isset($sender))
<div style="padding-bottom: 2em; padding-top: 1em;">

{!! $sender->render() !!}
@elseif (empty($personal_plan))
    @push('scripts')
    <script>
        $('#plan-div-personal').hide();
    </script>
    @endpush

</div>
@endif