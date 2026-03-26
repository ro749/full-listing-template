<div style="padding-top: 2rem;">
{!! $plans->render($personal_plan) !!}
</div>
<div style="padding-bottom: 2em; padding-top: 1em;">
@if(isset($sender))
{!! $sender->render() !!}
@elseif (empty($personal_plan))
    @push('scripts')
    <script>
        $('#plan-div-personal').hide();
    </script>
    @endpush
@endif
</div>