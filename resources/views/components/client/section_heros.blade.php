<section
    class="px-4 py-12 lg:pb-20 pt-40 overflow-hidden lg:px-8">
    <h2 class="sr-only">
        Section présentation
    </h2>

    <div
        class="max-w-7xl mx-auto
               grid grid-cols-1 lg:grid-cols-2
               items-center gap-14 lg:gap-20">

        <div
            class="flex flex-col justify-center
                   text-center lg:text-left">

            <span class="title_section max-w-[650px]">
                Gérez votre équipe de football simplement et efficacement
            </span>

            <p
                class="subtitle_section mt-6 max-w-[620px]
                       mx-auto lg:mx-0">
                Une application dédiée aux entraîneurs et aux joueurs pour améliorer la
                communication, organiser les entraînements et les matchs,
                et créer facilement vos compositions d’équipe.
            </p>

            <div
                class="flex flex-col sm:flex-row
                       justify-center lg:justify-start
                       items-center gap-5 mt-10">

                <a href="/profile" class="btn-primary">
                    Rejoindre une équipe
                </a>
                <a href="/create" class="btn-secondary">
                    Créer une équipe
                </a>
            </div>

        </div>

        <div class="flex justify-center w-full">

            <div
                x-data="{
                    current: 0,

                    images: [
                        '{{ asset('team.png') }}',
                        '{{ asset('convoc.png') }}',
                        '{{ asset('compos.png') }}',
                        '{{ asset('calendar.png') }}',
                    ],

                    init() {
                        setInterval(() => {
                            this.current =
                                (this.current + 1) % this.images.length
                        }, 3000)
                    }
                }"
                class="relative w-full
                       max-w-[320px]
                       sm:max-w-[500px]
                       md:max-w-[620px]
                       lg:max-w-[760px]">

                <div class="absolute overflow-hidden rounded-[2px] top-[8.4%] left-[15.9%] w-[67.8%] h-[63.8%] z-10">

                    <template
                        x-for="(image,index) in images"
                        :key="index">

                        <img
                            x-show="current === index"
                            x-transition.opacity.duration.700ms
                            :src="image"
                            class="absolute inset-0
                                   w-full h-full
                                   object-cover"
                            alt="">

                    </template>

                </div>

                <img
                    src="{{ asset('pc.png') }}"
                    alt="Image d'un ordinateur"
                    class="relative z-20 w-full h-auto">

            </div>

        </div>

    </div>

</section>
