<div class="card shrt-list text-center">
    <div class="delete-action-btn text-right">
        <span class="text-white"><i ng-click="deleteShortlist(shortlist.s_id)" class="fa fa-trash"></i></span>
    </div>
    <div ng-if="shortlist.type == 'job'">
        <div class="image pt-5"  ><div class="pic-holder">
            <!-- uploaded pic shown here -->
            <img id="profilePic" class="pic" src="https://source.unsplash.com/random/150x150">
            </div> 
        </div>
        <div class="about-product text-center" >
            <h3 class="shrt-lst-title-1">[[shortlist.title]]</h3>
            <span class="font-weight-bold">[[shortlist.location]] </span>
            {{-- <div class="ratings"> <i class="fa fa-star rating-color"></i> <i class="fa fa-star rating-color"></i> <i class="fa fa-star rating-color"></i> <i class="fa fa-star rating-color"></i> <i class="fa fa-star"></i> <span class="ml-1">4.6</span></div>  --}}
            <p class="shrt-lst-title-3 mt-2">[[shortlist.description]]</p>
            <button class="btn btn-success buy-now" ng-if="!shortlist.is_applied && !shortlist.is_invited" ng-click="invitationConfirmation(shortlist, 'received')">Apply</button>
            <button type="button" class="btn btn-success buy-now" ng-if="shortlist.is_applied || shortlist.is_invited" style="cursor: default">APPLIED</button>

        </div>
    </div>
</div>