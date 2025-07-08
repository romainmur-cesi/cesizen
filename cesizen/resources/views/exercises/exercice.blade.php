<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Exercices de Respiration CESIZen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.4/vue.global.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #27ae60, #f1c40f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #27ae60, #f1c40f);
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #2ecc71, #f39c12);
        }
        .breathing-circle {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .breathing-circle::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.7; }
            50% { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }
        }
        .breathing-circle.inhale {
            transform: scale(1.3);
            background: linear-gradient(135deg, #3498db, #2ecc71);
        }
        .breathing-circle.hold {
            transform: scale(1.3);
            background: linear-gradient(135deg, #9b59b6, #e74c3c);
        }
        .breathing-circle.exhale {
            transform: scale(0.8);
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }
        .phase-indicator {
            transition: all 0.3s ease;
        }
        .phase-indicator.active {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            transform: scale(1.1);
        }
        .countdown-text {
            font-size: 3rem;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .exercise-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .exercise-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(46, 204, 113, 0.2);
        }
        .exercise-card.selected {
            border-color: #27ae60;
            box-shadow: 0 10px 30px rgba(39, 174, 96, 0.3);
        }
        .stats-card {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
        }
        .progress-ring {
            transition: stroke-dashoffset 0.1s linear;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        .exercise-zone {
            position: relative;
            z-index: 1;
        }
        .exercise-title {
            position: relative;
            z-index: 10;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layouts/navigation')
    <div id="app" class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold gradient-text mb-2">Exercices de Respiration</h1>
            <p class="text-gray-600 text-lg">Retrouvez votre calme avec nos exercices de respiration guidée</p>
        </div>

        <!-- Sélection d'exercice -->
        <div class="mb-8" v-if="!isExerciseRunning">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Choisissez votre exercice</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="exercise in exercises"
                    :key="exercise.id"
                    class="exercise-card p-6 cursor-pointer"
                    :class="{ 'selected': selectedExercise && selectedExercise.id === exercise.id }"
                    @click="selectExercise(exercise)"
                >
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-4">
                            <i :class="exercise.icon" class="text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">@{{ exercise.name }}</h3>
                            <p class="text-sm text-gray-600">@{{ exercise.duration }}</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">@{{ exercise.description }}</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>@{{ exercise.inhale }}s - @{{ exercise.hold }}s - @{{ exercise.exhale }}s</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded">@{{ exercise.level }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone d'exercice -->
        <div class="text-center mb-8 exercise-zone" v-if="selectedExercise">
            <div class="exercise-card p-8 max-w-2xl mx-auto">
                <div class="exercise-title">
                    <h2 class="text-2xl font-bold text-gray-800">@{{ selectedExercise ? selectedExercise.name : '' }}</h2>
                </div>
                
                <!-- Animation de respiration -->
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div 
                            class="breathing-circle flex items-center justify-center"
                            :class="currentPhase"
                        >
                            <div class="text-center">
                                <div class="countdown-text">@{{ countdown }}</div>
                                <div class="text-white text-lg font-medium capitalize">@{{ currentPhaseText }}</div>
                            </div>
                        </div>
                        <!-- Anneau de progression -->
                        <svg class="absolute top-0 left-0 w-full h-full -rotate-90" viewBox="0 0 200 200">
                            <circle
                                cx="100"
                                cy="100"
                                r="95"
                                fill="none"
                                stroke="rgba(255,255,255,0.2)"
                                stroke-width="4"
                            />
                            <circle
                                cx="100"
                                cy="100"
                                r="95"
                                fill="none"
                                stroke="white"
                                stroke-width="4"
                                stroke-linecap="round"
                                class="progress-ring"
                                :stroke-dasharray="circumference"
                                :stroke-dashoffset="strokeDashoffset"
                            />
                        </svg>
                    </div>
                </div>

                <!-- Indicateurs de phase -->
                <div class="flex justify-center gap-4 mb-6">
                    <div 
                        class="phase-indicator px-4 py-2 rounded-lg border-2 border-gray-300"
                        :class="{ 'active': currentPhase === 'inhale' }"
                    >
                        <i class="fas fa-arrow-down mr-2"></i>
                        Inspirer
                    </div>
                    <div 
                        class="phase-indicator px-4 py-2 rounded-lg border-2 border-gray-300"
                        :class="{ 'active': currentPhase === 'hold' }"
                    >
                        <i class="fas fa-pause mr-2"></i>
                        Retenir
                    </div>
                    <div 
                        class="phase-indicator px-4 py-2 rounded-lg border-2 border-gray-300"
                        :class="{ 'active': currentPhase === 'exhale' }"
                    >
                        <i class="fas fa-arrow-up mr-2"></i>
                        Expirer
                    </div>
                </div>

                <!-- Contrôles -->
                <div class="flex justify-center gap-4">
                    <button 
                        v-if="!isExerciseRunning"
                        @click="startExercise"
                        class="btn-gradient text-white px-8 py-3 rounded-lg font-medium text-lg transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-lg"
                    >
                        <i class="fas fa-play mr-2"></i>
                        Démarrer l'exercice
                    </button>
                    <button 
                        v-if="isExerciseRunning"
                        @click="pauseExercise"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300"
                    >
                        <i class="fas fa-pause mr-2"></i>
                        @{{ isPaused ? 'Reprendre' : 'Pause' }}
                    </button>
                    <button 
                        v-if="isExerciseRunning"
                        @click="stopExercise"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300"
                    >
                        <i class="fas fa-stop mr-2"></i>
                        Arrêter
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" v-if="isExerciseRunning">
            <div class="stats-card fade-in">
                <div class="text-2xl font-bold">@{{ completedCycles }}</div>
                <div class="text-green-100">Cycles terminés</div>
            </div>
            <div class="stats-card fade-in">
                <div class="text-2xl font-bold">@{{ formatTime(totalTime) }}</div>
                <div class="text-green-100">Temps total</div>
            </div>
            <div class="stats-card fade-in">
                <div class="text-2xl font-bold">@{{ currentCycle }}/@{{ selectedExercise ? selectedExercise.cycles : 0 }}</div>
                <div class="text-green-100">Progression</div>
            </div>
        </div>

        <!-- Message de fin -->
        <div v-if="isExerciseComplete" class="text-center exercise-card p-8 max-w-md mx-auto fade-in">
            <div class="text-6xl mb-4">🎉</div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Félicitations !</h3>
            <p class="text-gray-600 mb-4">Vous avez terminé votre exercice de respiration</p>
            <button 
                @click="resetExercise"
                class="btn-gradient text-white px-6 py-3 rounded-lg font-medium transition-all duration-300"
            >
                Recommencer
            </button>
        </div>
    </div>

    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    exercises: [
                        {
                            id: 1,
                            name: "Respiration 4-7-8",
                            description: "Technique de relaxation profonde pour réduire le stress",
                            inhale: 4,
                            hold: 7,
                            exhale: 8,
                            cycles: 4,
                            duration: "5 min",
                            level: "Débutant",
                            icon: "fas fa-leaf"
                        },
                        {
                            id: 2,
                            name: "Cohérence cardiaque",
                            description: "Rythme 5-5-5 pour harmoniser le système nerveux",
                            inhale: 5,
                            hold: 0,
                            exhale: 5,
                            cycles: 10,
                            duration: "3 min",
                            level: "Débutant",
                            icon: "fas fa-heart"
                        },
                        {
                            id: 3,
                            name: "Box Breathing",
                            description: "Technique militaire pour la concentration",
                            inhale: 4,
                            hold: 4,
                            exhale: 4,
                            cycles: 6,
                            duration: "4 min",
                            level: "Intermédiaire",
                            icon: "fas fa-square"
                        }
                    ],
                    selectedExercise: null,
                    isExerciseRunning: false,
                    isPaused: false,
                    isExerciseComplete: false,
                    currentPhase: 'inhale',
                    currentPhaseText: 'inspirer',
                    countdown: 0,
                    currentCycle: 0,
                    completedCycles: 0,
                    totalTime: 0,
                    timer: null,
                    phaseTimer: null,
                    circumference: 2 * Math.PI * 95
                };
            },
            computed: {
                strokeDashoffset() {
                    if (!this.selectedExercise) return this.circumference;
                    
                    const currentPhaseDuration = this.getCurrentPhaseDuration();
                    const progress = (currentPhaseDuration - this.countdown) / currentPhaseDuration;
                    return this.circumference - (progress * this.circumference);
                }
            },
            methods: {
                selectExercise(exercise) {
                    this.selectedExercise = exercise;
                    this.resetExercise();
                },
                startExercise() {
                    if (!this.selectedExercise) return;
                    
                    this.isExerciseRunning = true;
                    this.isPaused = false;
                    this.isExerciseComplete = false;
                    this.currentCycle = 1;
                    this.completedCycles = 0;
                    this.totalTime = 0;
                    
                    this.startPhase('inhale');
                    this.startTotalTimer();
                },
                startPhase(phase) {
                    this.currentPhase = phase;
                    this.currentPhaseText = this.getPhaseText(phase);
                    this.countdown = this.getCurrentPhaseDuration();
                    
                    this.phaseTimer = setInterval(() => {
                        if (!this.isPaused) {
                            this.countdown--;
                            
                            if (this.countdown <= 0) {
                                this.nextPhase();
                            }
                        }
                    }, 1000);
                },
                nextPhase() {
                    clearInterval(this.phaseTimer);
                    
                    if (this.currentPhase === 'inhale') {
                        if (this.selectedExercise.hold > 0) {
                            this.startPhase('hold');
                        } else {
                            this.startPhase('exhale');
                        }
                    } else if (this.currentPhase === 'hold') {
                        this.startPhase('exhale');
                    } else if (this.currentPhase === 'exhale') {
                        this.completedCycles++;
                        
                        if (this.currentCycle < this.selectedExercise.cycles) {
                            this.currentCycle++;
                            this.startPhase('inhale');
                        } else {
                            this.completeExercise();
                        }
                    }
                },
                getCurrentPhaseDuration() {
                    if (!this.selectedExercise) return 0;
                    
                    switch (this.currentPhase) {
                        case 'inhale': return this.selectedExercise.inhale;
                        case 'hold': return this.selectedExercise.hold;
                        case 'exhale': return this.selectedExercise.exhale;
                        default: return 0;
                    }
                },
                getPhaseText(phase) {
                    switch (phase) {
                        case 'inhale': return 'inspirer';
                        case 'hold': return 'retenir';
                        case 'exhale': return 'expirer';
                        default: return '';
                    }
                },
                pauseExercise() {
                    this.isPaused = !this.isPaused;
                },
                stopExercise() {
                    this.isExerciseRunning = false;
                    this.isPaused = false;
                    clearInterval(this.phaseTimer);
                    clearInterval(this.timer);
                    this.resetExercise();
                },
                completeExercise() {
                    this.isExerciseRunning = false;
                    this.isExerciseComplete = true;
                    clearInterval(this.phaseTimer);
                    clearInterval(this.timer);
                },
                resetExercise() {
                    this.isExerciseRunning = false;
                    this.isPaused = false;
                    this.isExerciseComplete = false;
                    this.currentPhase = 'inhale';
                    this.currentPhaseText = 'inspirer';
                    this.countdown = 0;
                    this.currentCycle = 0;
                    this.completedCycles = 0;
                    this.totalTime = 0;
                    clearInterval(this.phaseTimer);
                    clearInterval(this.timer);
                },
                startTotalTimer() {
                    this.timer = setInterval(() => {
                        if (!this.isPaused) {
                            this.totalTime++;
                        }
                    }, 1000);
                },
                formatTime(seconds) {
                    const mins = Math.floor(seconds / 60);
                    const secs = seconds % 60;
                    return `${mins}:${secs.toString().padStart(2, '0')}`;
                }
            },
            mounted() {
                // Initialiser le premier exercice
                if (this.exercises.length > 0) {
                    this.selectedExercise = this.exercises[0];
                }
            }
        }).mount('#app');
    </script>
</body>
</html>