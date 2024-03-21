(function($) {
	'use strict';
  
	$(document).ready(function() {
	  const clusterID = getParameterByName('code');
	  console.log('Cluster ID: ' + clusterID);
	  fetchClusterData(clusterID);
	});
  
	function fetchClusterData(clusterID) {
	  $.ajax({
		url: cimne_vars.ajaxurl,
		type: 'post',
		data: {
		  action: 'cimne_ajax_test',
		  id_post: clusterID
		},
		success: function(response) {
		  const cluster = JSON.parse(response);
  
		  displayClusterName(cluster);
		  displayGroupList(cluster);
		  displayLeadersList(cluster);
		  displayPeopleList(cluster);
		},
		error: function(xhr, status, error) {
		  console.error('Error: ' + error);
		}
	  });
	}
  
	function displayClusterName(cluster) {
	  const clusterName = cluster.Nombre || '';
	  const clusterNameItem = `<h2>${clusterName}</h2>`;
  
	  document.getElementById('data-title').innerHTML = clusterNameItem;
	}
  
	function displayGroupList(cluster) {
	  const groupList = document.getElementById('data-groups');
	  const listItem = document.createElement('ul');
	  
	  cluster.RTDGrupos.forEach(group => {
		const groupName = group.Nombre || '';

		const groupItems = `<li><a href="#">${groupName}</a></li>`;		
		
		listItem.innerHTML += groupItems;
  
		groupList.appendChild(listItem);
	  });
	}
  
	function displayLeadersList(cluster) {
	  const leadersList = document.getElementById('data-leaders');
	  const listItem = document.createElement('ul');
	  
	  cluster.Leaders.forEach(leader => {
		const idPersonal = leader.Id_Personal || '';
		const nombre = leader.Nombre || '';
		const apellido1 = leader.Apellido1 || '';
		const apellido2 = leader.Apellido2 || '';
  
		const leadersItems = `<li><a href="#${idPersonal}">${nombre} ${apellido1} ${apellido2}</a></li>`;
  
		
		listItem.innerHTML += leadersItems;
  
		leadersList.appendChild(listItem);
	  });
	}
  
	function displayPeopleList(cluster) {
	  const peopleList = document.getElementById('data-people');
	  const listItem = document.createElement('ul');
	  cluster.Personal.forEach(person => {
		const idPersonal = person.IDSIGPRO || '';
		const nombre = person.Nombre || '';
		const apellido1 = person.Apellido1 || '';
		const apellido2 = person.Apellido2 || '';
  
		const peopleItems = `<li><a href="#${idPersonal}">${nombre} ${apellido1} ${apellido2}</a></li>`;
  
		
		listItem.innerHTML += peopleItems;
  
		peopleList.appendChild(listItem);
	  });
	}
  })(jQuery);



function getParameterByName(name, url=window.location.href) {
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}
//isParameterByName('origin');
// origin > True
function isParameterByName(name) {
	let regex = new RegExp('[?&]' + name + '=');
	return regex.test(window.location.href);
}
