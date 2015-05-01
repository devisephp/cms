devise.define(['dvsLiveUpdate'], function(LiveUpdate)
{
	// returns a global singleton we can work with everywhere
	return new LiveUpdate;
});