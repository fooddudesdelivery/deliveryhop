/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
document.addEventListener('deviceready', onDeviceReady, false);




function onDeviceReady() {

	document.querySelector("#playMp3").addEventListener("touchend", playMP3, false);
};

function playMP3() {
    var mp3URL = getMediaURL("sound/alarm-beep.wav");
    var media = new Media(mp3URL, null, mediaError);
    media.play();
}
function loopMP3() {
	var myMedia;
    var mp3URL = getMediaURL("sound/alarm-beep.wav");
	var max_loop=5;
	var loop_count = 0;
	var loop = function (status) {
					if (status === Media.MEDIA_STOPPED && loop_count<max_loop) {
						myMedia.play();
						loop_count++;
					}
				};
    myMedia = new Media(mp3URL, null, mediaError,loop);
	myMedia.play();

}
function getMediaURL(s) {
    if(device.platform.toLowerCase() === "android") return "/android_asset/www/" + s;
    return s;
}

function mediaError(e) {
    alert('Media Error');
    alert(JSON.stringify(e));
}