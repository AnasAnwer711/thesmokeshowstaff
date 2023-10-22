<div class="card shrt-list text-center">
    <div class="delete-action-btn text-right">
        <span class="text-white"><i ng-click="deleteShortlist(shortlist.s_id)" class="fa fa-trash"></i></span>
    </div>
    <div ng-if="shortlist.type == 'staff'">

        <div class="image pt-5" ><div class="pic-holder">
            <!-- uploaded pic shown here -->
            <img id="profilePic" class="pic" ng-src="[[shortlist.display_pic ? shortlist.display_pic : 'https://source.unsplash.com/random/150x150']]">
            </div> 
        </div>
        <div class="about-product text-center" >
            <h3 class="shrt-lst-title-1">[[shortlist.name]]</h3>
            <span class="font-weight-bold">[[shortlist.address ? shortlist.address.address_line1 : '']] </span>
            <div class="ratings-col d-flex justify-content-center my-1 align-items-center" ng-if="shortlist.average_rating > 0">
                <div class="ratings">
                    <i class="fa fa-star [[($index+1) <= shortlist.average_rating ? 'rating-color' : '']]" ng-repeat="x in [].constructor(5) track by $index"
                    ></i>
                </div>
            </div>
            {{-- <div class="ratings"> <i class="fa fa-star rating-color"></i> <i class="fa fa-star rating-color"></i> <i class="fa fa-star rating-color"></i> <i class="fa fa-star rating-color"></i> <i class="fa fa-star"></i> <span class="ml-1">4.6</span></div>  --}}
            {{-- <p class="shrt-lst-title-3 mt-2">Hi, i’m a [[shortlist.name]]/[[shortlist.nationality.name]]. [[shortlist.address ? 'Living in '+shortlist.address.suburb+'('+shortlist.address.state.name+').'  : '']]</p> --}}
            <p class="shrt-lst-title-3 mt-2" ng-if="shortlist.resume">[[shortlist.resume]]</p>

            <button class="btn btn-success buy-now" ng-click="invitationConfirmation(shortlist, 'invite')">INVITE</button>

        </div>
    </div>
</div>