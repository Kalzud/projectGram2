import React, { useState } from 'react';
import ReactDOM from 'react-dom/client';

function FollowButton({ userId, follows, followers}) {

    const [followersNo, setFollowersNo] = useState(Number(followers)); // Initial count is that of followers
    {document.getElementById('followers-count').innerHTML = '<strong>' + followersNo + '</strong> followers'} //for the followers section
    const [isfollows, setFollows] = useState(follows); //set status for is followed or not followed


    function followUser() {
        axios.post(`/follow/${userId}`).then(response => {

            setFollows(!isfollows); // Toggle the follow status

            //toggle the followers number
            if(isfollows){
                setFollowersNo(followersNo - 1); //decrease with unfollow
            }else{
                setFollowersNo(followersNo + 1); //increse with follow
            }
            // console.log(followersNo);
            // console.log(response.data);
        }).catch(errors => {
            if(errors.response.status == 401){
                window.location = '/login';
            }
        });
    }

    return (
        <div>
            <button className="btn btn-primary ms-4" onClick={() => {followUser();}}>
                {isfollows ? 'Unfollow' : 'Follow'}
            </button>
        </div>
    );

}

export default FollowButton;

if (document.getElementById('follow-button-container')) {
    const follows = document.getElementById('follow-button-container').getAttribute('follows');
    const followers = document.getElementById('follow-button-container').getAttribute('followers');
    const userId = document.getElementById('follow-button-container').getAttribute('user-id');
    const Index = ReactDOM.createRoot(document.getElementById("follow-button-container"));

    Index.render(
        <React.StrictMode>
            <FollowButton userId={userId} follows={follows} followers={followers}/>
        </React.StrictMode>
    )

}
