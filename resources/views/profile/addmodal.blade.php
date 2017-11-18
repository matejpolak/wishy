

<!-- Wishes Add Modal -->
<!-- ---------------------- -->
<div class="modal fade" id="addwishModal" tabindex="-1" role="dialog" aria-labelledby="addwishLabel" aria-hidden="true">
    <div class="modal-dialog bg-navy wishy-rounded" role="document">
        <div class="modal-content bg-navy wishy-rounded">
            <div class="modal-header wishy-rounded-top bg-navy text-white">
                <h5 class="modal-title" id="addwishLabel">Add Wish</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-navy text-white">
                <form class="mb-2" method="post" action="{{action('WishController@store')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">Wish Title</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input name="description" type="text" class="form-control" id="description" placeholder="Enter description">
                    </div>
                    <div class="form-group">
                        <label for="is_public">Make it public? </label>
                        <input name="is_public" type="checkbox" class="form-control" id="is_public" checked>
                    </div>
                    <button type="submit" class="btn btn-gold">Submit</button>
                </form>
            </div>
            <div class="modal-footer wishy-rounded-bottom bg-navy text-white">
                <button type="button" class="btn btn-gold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>