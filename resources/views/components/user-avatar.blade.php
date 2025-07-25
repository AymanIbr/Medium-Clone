 @props(['user', 'size' => 'w-12 h-12'])

 @php
     if ($user->image) {
         $url = asset('storage/' . $user->image->path);
     } else {
         $url = 'https://ui-avatars.com/api/?background=random&name=' . urlencode(string: $user->name);
     }
 @endphp
 <img src="{{ $url }}" alt="{{ $user->name }}" class="{{ $size }} rounded-full">
