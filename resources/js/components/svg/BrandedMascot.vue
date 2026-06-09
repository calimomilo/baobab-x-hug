<script setup lang="ts">

const props = defineProps({
    type: {type: String, default: null},
    primary: {type: String, default: '#C8E2DF'},
    secondary: {type: String, default: '#009692'},
    class: {type: String, default: ''}
})
</script>

<template>
    <div v-if="props.type === 'holding-hands'" class="w-fit" :class="props.class">
        <svg class="m-auto" width="256" height="148" viewBox="0 0 256 148" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M227.624 24.4822C228.159 26.905 229.465 29.1525 231.311 30.8139C232.622 26.4943 233.268 21.8378 232.705 16.8352" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M231.312 30.8185C233.513 27.2327 235.11 23.1162 235.557 18.312" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M231.312 30.8185C234.431 28.3311 236.609 25.0637 237.551 21.021" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M212.985 54.0871C213.105 59.7635 214.148 65.4168 216.063 70.7609C216.507 71.9885 217 73.2207 217.799 74.2544C218.597 75.2882 219.737 76.1189 221.034 76.285C222.654 76.4927 224.264 75.6204 225.335 74.3882C226.406 73.1561 227.024 71.6008 227.555 70.0594C231.441 58.8313 231.316 43.2374 231.316 30.814" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M148.018 68.4231C137.951 79.9314 128.901 92.3316 121.017 105.435C120.277 107.382 120.269 109.041 119.443 110.583" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M121.017 105.435C119.279 107.208 117.356 109.81 116.535 112.154" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M119.903 105.056C118.024 106.211 115.802 108.044 114.589 109.893" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M253.722 2.63977L252.669 1.61523" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M249.785 11.5142H248.225" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M253.422 19.0459C252.9 19.392 252.383 19.7381 251.862 20.0843" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M185.259 79.1462C190.561 100.827 191.886 123.477 189.135 145.629H191.974M175.217 84.2827C176.444 104.898 174.261 125.716 168.77 145.629L166.711 142.334" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M181.707 1.61523L195.039 12.0854L211.982 12.6322L215.46 29.2218L228.087 40.5296L220.092 55.4785L222.494 72.2585L206.762 78.5648L197.815 92.9634L181.707 87.6851L165.602 92.9634L156.655 78.5648L140.923 72.2585L143.325 55.4785L135.33 40.5296L147.957 29.2218L151.435 12.6322L168.378 12.0854L181.707 1.61523Z" fill="#FFC0DE"/>
            <path d="M181.991 47.8738L181.998 47.7124" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M176.716 46.1377L176.723 45.9763" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M166.99 44.9893C166.357 49.0191 166.596 53.2917 168.394 56.9526C170.191 60.6136 173.717 63.5587 177.769 63.9894C181.696 64.4059 185.651 62.4125 188.153 59.3538C190.65 56.295 191.808 52.3001 191.985 48.3537" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M202.873 21.5319C200.733 26.0507 196.854 29.7145 192.224 31.6069C187.594 33.4946 182.26 33.5898 177.568 31.8586C176.352 31.4126 175.116 30.7902 174.454 29.6783C173.187 27.5443 174.617 24.8306 176.284 22.99C177.024 22.1745 177.84 21.3944 178.859 20.9828C179.878 20.5711 181.133 20.5938 181.978 21.2974C182.957 22.1081 183.108 23.6383 182.572 24.7899C182.036 25.9415 180.955 26.7572 179.802 27.2882C177.294 28.4483 174.277 28.4518 171.77 27.298C169.262 26.1396 167.308 23.8441 166.565 21.1816" stroke="#F60065" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10.0922 68.5527C9.39554 78.5498 8.80142 89.0938 13.2678 98.0608C14.0927 99.7234 15.1057 101.326 16.5118 102.536C17.918 103.75 19.7644 104.532 21.6108 104.361C24.5043 104.096 26.7054 101.655 28.2313 99.1806C31.1505 94.4535 32.7746 88.9357 32.8815 83.3837" :stroke="props.primary" stroke-width="2.99184" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10.0923 68.553C9.97262 64.6251 8.68186 61.0562 6.78418 57.6113" :stroke="props.primary" stroke-width="2.99184" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10.0923 68.5529C11.2677 64.9969 11.6822 61.2272 12.0028 57.2822" :stroke="props.primary" stroke-width="2.99184" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9.60922 71.2201C9.1519 69.5617 7.92953 67.4888 6.72852 66.7708" :stroke="props.primary" stroke-width="2.99184" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M5.87857 72.0234C4.69038 71.2712 3.83128 70.0103 3.56201 68.6255" :stroke="props.primary" stroke-width="2.99184" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2.18947 72.9936C1.1637 71.4208 1.28765 69.1855 2.48438 67.7366C2.81348 67.3391 3.32209 66.9758 3.80933 67.1553" :stroke="props.primary" stroke-width="2.99184" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M45.712 85.8032C37.3306 97.5697 34.8217 113.315 39.13 127.103C41.1003 133.408 44.3785 139.246 46.3531 145.55L43.4383 145.601" :stroke="props.primary" stroke-width="2.99184" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M55.3677 84.3027C56.7226 88.5554 58.0732 92.8081 59.4281 97.0651C61.0394 102.121 62.6593 107.237 63.044 112.533C63.8817 124.073 58.8212 135.134 53.8804 145.601H57.1586" :stroke="props.primary" stroke-width="2.99184" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M85.4882 69.3465C95.5553 80.8548 104.605 93.2549 112.489 106.358C113.229 108.305 113.237 109.964 114.063 111.506" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M112.489 106.358C114.227 108.131 116.15 110.734 116.971 113.077" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M113.603 105.979C115.482 107.134 117.704 108.967 118.917 110.817" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M18.4141 91.7312C14.0589 91.5175 11.2594 86.2134 13.0203 81.529C17.0293 70.8696 21.2478 60.0433 25.6971 49.0676C31.3774 35.0487 37.1345 23.6113 42.9258 12.097C47.4734 3.05739 58.5946 3.04029 63.1635 12.0671C67.6085 20.8588 72.0407 29.6762 76.4473 40.4682C81.5719 53.0253 86.4315 65.3945 91.0475 77.5499C93.5991 84.273 89.5387 91.8808 83.2772 92.1159C72.6092 92.5176 61.5906 92.7014 50.2473 92.6245C39.3185 92.5518 28.7018 92.2398 18.4141 91.7355V91.7312Z" :fill="props.secondary"/>
            <path d="M63.701 43.6804L63.6226 43.5327" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M68.8558 41.1008L68.7773 40.8193" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M55.7627 48.7202C57.0272 51.8491 59.5193 54.4612 62.5836 55.8734C65.6479 57.2902 69.2476 57.4886 72.4503 56.4272" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M57.4282 51.6692C57.8759 51 58.4112 50.4093 59.0896 49.9755C60.3726 49.1494 62.2785 49.1217 63.2523 50.2939C64.106 51.323 63.9538 52.8552 63.5061 54.1151C63.2846 54.7381 62.9985 55.338 62.7539 55.9472" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M62.9942 17.3062C61.7159 23.7717 58.4023 29.8403 53.5936 34.3584C52.6752 35.2167 51.563 36.0751 50.3123 35.9736C49.1032 35.8767 48.1248 34.866 47.691 33.7353C47.2572 32.6047 47.2619 31.3587 47.2711 30.1449C46.565 31.294 46.0066 32.5355 45.4343 33.7584C44.8621 34.9814 44.1745 36.1859 43.1638 37.0766C42.1485 37.9673 40.7548 38.5118 39.4349 38.2303C38.115 37.9488 36.9844 36.6935 37.1044 35.3506C37.1459 34.8752 37.3536 34.3953 37.7458 34.1184C38.1381 33.8415 38.7242 33.8276 39.0657 34.1599C39.4488 34.5291 39.4072 35.1891 39.1119 35.6367C38.8165 36.0844 38.3366 36.3659 37.8704 36.6243C36.0475 37.6442 33.8185 38.5857 31.9541 37.6488" :stroke="props.primary" stroke-width="3.23046" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <div v-if="props.type === 'flag'" class="w-fit" :class="props.class">
        <svg class="mx-auto my-auto" width="123" height="167" viewBox="0 0 123 167" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M97.9694 64.2634C101.412 72.8215 101.681 82.326 100.923 91.5216C100.59 95.5815 100.037 99.721 98.2384 103.377C96.4351 107.034 93.1773 110.187 89.1623 110.899C85.8596 111.482 82.4075 110.351 79.7076 108.354C77.0127 106.361 74.9952 103.577 73.3762 100.638C70.4721 95.3722 68.7286 89.4743 68.2803 83.4767" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M97.9638 64.2685C96.1954 63.1327 94.3324 62.1115 92.3647 61.3793" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M119.46 7.34569L87.8888 2.54119C87.0295 2.41042 86.318 3.20374 86.5411 4.04381L92.1286 25.0759C92.3371 25.8606 93.2453 26.2196 93.9339 25.7895L119.918 9.5619C120.867 8.96874 120.567 7.51416 119.46 7.34569Z" :fill="props.primary"/>
            <path d="M105.141 74.8595L85.8192 1.80721" stroke="#7E4910" stroke-width="3.48696" stroke-linecap="round"/>
            <path d="M100.988 50.8877C99.5086 55.1866 98.059 59.7197 97.9644 64.2677C99.2147 60.4769 101.347 56.7956 103.882 53.7121" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M104.276 59.0332C101.935 60.438 99.5235 62.027 97.9644 64.2687" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M52.0257 94.7043C50.0082 118.222 46.1277 141.579 40.439 164.489L43.2535 164.683" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M38.4014 95.9897C35.547 105.449 32.6976 114.909 29.8433 124.369C25.7934 137.804 21.7386 151.238 17.6887 164.678C16.4932 164.658 14.8842 163.891 14.2964 163.044" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M11.5615 84.7319C12.3087 97.5839 12.5429 108.956 13.3648 122.033C14.7745 123.891 15.711 125.968 16.0597 127.353" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12.7971 132.1C12.6975 126.859 12.8768 123.532 13.37 122.032C11.746 123.691 10.9092 128.329 10.9092 130.087" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6.90883 100.727C1.83279 100.478 -1.43002 94.296 0.622315 88.8364C5.29486 76.4128 10.2115 63.795 15.3971 51.0028C22.0174 34.6638 28.7273 21.3336 35.4771 7.9137C40.7773 -2.62195 53.7389 -2.64187 59.064 7.87883C64.2446 18.1256 69.4104 28.4022 74.5462 40.9802C80.5189 55.6155 86.1827 70.0317 91.5626 84.1988C94.5365 92.0345 89.8042 100.901 82.5065 101.175C70.0729 101.644 57.2309 101.858 44.0102 101.768C31.2728 101.683 18.899 101.32 6.90883 100.732V100.727Z" :fill="props.secondary"/>
            <path d="M34.546 16.8099C34.1275 20.8748 33.6991 24.9844 34.267 29.0293C34.6804 31.9932 36.1001 35.3357 39.0242 35.9584C41.3057 36.4416 43.642 34.9572 44.8774 32.9795C46.1128 30.9969 46.4914 28.6208 46.8351 26.3144C46.4864 28.4714 46.1376 30.718 46.7254 32.8201C47.3083 34.9273 49.1016 36.87 51.2884 36.88C52.8127 36.8899 54.2324 35.9534 55.1241 34.718C56.0207 33.4827 56.4541 31.9733 56.7231 30.4739C56.8178 31.6047 57.2312 32.8052 57.7842 33.8015C58.3371 34.7977 59.4679 35.5699 60.5787 35.3308C61.2163 35.1963 61.7543 34.7579 62.1578 34.2498C63.5625 32.4665 63.3783 29.632 61.7493 28.048" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M43.7664 45.8018L43.7515 45.6274" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M50.3568 46.589L50.3418 46.4147" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M42.5217 54.0764C42.4619 57.2994 42.8106 60.5223 43.5379 63.6606C43.8019 64.8113 44.1407 65.977 44.8779 66.8985C45.6151 67.8151 46.8555 68.4228 47.9863 68.104C48.8132 67.8749 49.4558 67.1874 49.8294 66.4103C50.203 65.6382 50.3375 64.7764 50.4421 63.9196C50.8257 60.9159 50.9103 57.8772 50.7011 54.8535" :stroke="props.primary" stroke-width="3.48698" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>


</template>