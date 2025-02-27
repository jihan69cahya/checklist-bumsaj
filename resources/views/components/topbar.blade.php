<div class="w-full bg-white shadow-md py-3 px-6 flex justify-end items-center z-10">
    <span class="text-gray-600">Selamat Datang, <strong id="user-name" class="text-black">Loading...</strong></span>
    <span class="text-gray-500 ml-4">
        <i class="fas fa-user-circle"></i>
    </span>
</div>

<script>
    fetch('/topbar/username')
        .then(response => response.json())
        .then(data => {
            document.getElementById('user-name').innerText = data.userName;
        })
        .catch(error => console.error('Error fetching username:', error));
</script>