
@if(Config::get('lorekeeper.settings.show_terms_popup') == 1)
<div class="modal fade d-none" id="termsModal" role="dialog" style="display:inline;overflow:auto;" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ Config::get('lorekeeper.settings.terms_popup')['title'] }}</h5>
            </div>
            <div class="modal-body">
                {!! Config::get('lorekeeper.settings.terms_popup')['text'] !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="termsButton">               
                    {{ Config::get('lorekeeper.settings.terms_popup')['button'] }}
                </button>
            </div>
        </div>
    </div>
</div>
<div class="fade modal-backdrop d-none" id="termsBackdrop"></div>


<script>
    $( document ).ready(function(){
        var termsButton = $('#termsButton');
        let termsAccepted = localStorage.getItem("terms_accepted");
        let user = "{{ Auth::user() != null }}" 
        let userAccepted = "{{ Auth::user()?->has_accepted_terms > 0 }}"

        if(user){
            if(!userAccepted){
                showPopup();
            }
        } else {
            if(!termsAccepted){
                showPopup();
            }
        }

        termsButton.on('click', function(e) {
            e.preventDefault();
            localStorage.setItem("terms_accepted", true);
            window.location.replace("/terms/accept");
        });

        function showPopup(){
            $('#termsModal').addClass("show");
            $('#termsModal').removeClass("d-none");
            $('#termsBackdrop').addClass("show");
            $('#termsBackdrop').removeClass("d-none");
        }

    });

</script>
@endif