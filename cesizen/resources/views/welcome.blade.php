<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Articles CESIZen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.4/vue.global.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        /* (Vos styles existants restent inchangés) */
        .gradient-text {
            background: linear-gradient(135deg, #27ae60, #f1c40f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(46, 204, 113, 0.3);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #27ae60, #f1c40f);
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #2ecc71, #f39c12);
        }
        .category-badge {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
        }
        .filter-btn {
            transition: all 0.3s ease;
        }
        .filter-btn.active {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
        }
        .filter-btn:not(.active) {
            background: white;
            color: #27ae60;
            border: 2px solid #27ae60;
        }
        .filter-btn:not(.active):hover {
            background: rgba(39, 174, 96, 0.1);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .navbar {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            box-shadow: 0 4px 20px rgba(46, 204, 113, 0.3);
        }
        .article-content {
            line-height: 1.8;
        }
        .article-content h2 {
            color: #27ae60;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 2rem 0 1rem 0;
        }
        .article-content h3 {
            color: #2ecc71;
            font-size: 1.25rem;
            font-weight: 600;
            margin: 1.5rem 0 0.75rem 0;
        }
        .article-content p {
            margin-bottom: 1rem;
            color: #4a5568;
        }
        .article-content ul, .article-content ol {
            margin: 1rem 0;
            padding-left: 1.5rem;
        }
        .article-content li {
            margin-bottom: 0.5rem;
            color: #4a5568;
        }
        .article-content strong {
            color: #27ae60;
            font-weight: 600;
        }
        .article-content em {
            color: #2ecc71;
            font-style: italic;
        }
        .back-btn {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }
        .back-btn:hover {
            background: linear-gradient(135deg, #2980b9, #1f639a);
        }
        .reading-time {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }
        .share-btn {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
        }
        .share-btn:hover {
            background: linear-gradient(135deg, #8e44ad, #7d3c98);
        }
        .modal-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }
        .modal-content {
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }
        .modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .modal-content::-webkit-scrollbar-thumb {
            background: #27ae60;
            border-radius: 4px;
        }
        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #2ecc71;
        }
    </style>
</head>
<body class="bg-gray-50">
@include('layouts/navigation')
    <div id="app" class="container mx-auto px-4 py-8">
        <!-- Modal Article -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay" @click="closeModal">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl mx-4 modal-content" @click.stop>
                <!-- Header Modal -->
                <div class="sticky top-0 bg-white border-b p-6 rounded-t-xl">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h1 class="text-2xl md:text-3xl font-bold gradient-text mb-2">
                                @{{ selectedArticle?.titre }}
                            </h1>
                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                <span class="category-badge text-white px-3 py-1 rounded-full text-sm font-medium">
                                    @{{ selectedArticle?.categorie }}
                                </span>
                                <span class="reading-time text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-clock mr-1"></i>
                                    @{{ selectedArticle?.temps_lecture }} min
                                </span>
                            </div>
                            <div class="flex items-center text-gray-600 text-sm">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                @{{ formatDate(selectedArticle?.created_at) }}
                                <i class="fas fa-user ml-3 mr-1"></i>
                                @{{ selectedArticle?.auteur }}
                            </div>
                        </div>
                        <button @click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl ml-4">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- Contenu Modal -->
                <div class="p-6">
                    <div class="mb-6">
                        <p class="text-lg text-gray-700 leading-relaxed font-medium">
                            @{{ selectedArticle?.description }}
                        </p>
                    </div>

                    <div class="article-content prose max-w-none" v-html="selectedArticle?.contenu"></div>
                </div>
            </div>
        </div>
        <!-- Vue Liste des Articles -->
        <div>
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold gradient-text mb-2">Articles CESIZen</h1>
                <p class="text-gray-600 text-lg">Découvrez nos contenus sur le bien-être et la relaxation</p>
            </div>
            <!-- Recherche & Filtre -->
            <div class="mb-8 flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Rechercher dans les articles..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    />
                </div>
                <div class="flex flex-wrap gap-2">
                    <button
                        @click="selectedCategory = ''"
                        :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedCategory === '' }]"
                    >
                        Toutes
                    </button>
                    <button
                        v-for="category in categories"
                        :key="category"
                        @click="selectedCategory = category"
                        :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedCategory === category }]"
                    >
                        @{{ category }}
                    </button>
                </div>
            </div>
            <!-- Statistiques -->
            <div class="mb-6 text-center">
                <p class="text-gray-600">
                    <span class="font-semibold text-green-600">@{{ filteredArticles.length }}</span>
                    article@{{ filteredArticles.length > 1 ? 's' : '' }}
                    @{{ selectedCategory ? `dans la catégorie "${selectedCategory}"` : 'au total' }}
                </p>
            </div>
            <!-- Liste Articles -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="article in paginatedArticles"
                    :key="article.id"
                    class="bg-white rounded-xl shadow-lg p-6 transition-all duration-300 cursor-pointer card-hover border border-gray-200"
                    @click="consultArticle(article)"
                >
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">
                                @{{ article.titre }}
                            </h3>
                            <span class="category-badge text-white px-3 py-1 rounded-full text-sm font-medium">
                                @{{ article.categorie }}
                            </span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                        @{{ article.description }}
                    </p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            @{{ formatDate(article.created_at) }}
                        </div>
                        <button @click.stop="consultArticle(article)" class="btn-gradient text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md">
                            <i class="fas fa-eye mr-1"></i>
                            Consulter
                        </button>
                    </div>
                </div>
            </div>
            <!-- Pas d'article -->
            <div v-if="filteredArticles.length === 0" class="text-center py-12">
                <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-600 text-lg">Aucun article trouvé</p>
                <p class="text-gray-500">Essayez de modifier vos critères de recherche</p>
            </div>
        </div>
    </div>
    <script>
        const { createApp } = Vue;
        createApp({
            data() {
                return {
                    showModal: false,
                    selectedArticle: null,
                    searchQuery: '',
                    selectedCategory: '',
                    currentPage: 1,
                    articlesPerPage: 6,
                    articles: [
                        {
                            id: 1,
                            titre: "Introduction à la méditation pleine conscience",
                            description: "Découvrez les bases de la méditation pleine conscience pour améliorer votre bien-être quotidien et développer une relation plus sereine avec vos pensées et émotions.",
                            categorie: "Méditation",
                            created_at: "2024-01-15T10:30:00Z",
                            auteur: "Dr. Marie Dubois",
                            temps_lecture: 8,
                            contenu: `
                                <h2>Qu'est-ce que la méditation pleine conscience ?</h2>
                                <p>La méditation pleine conscience, ou <strong>mindfulness</strong>, est une pratique ancestrale qui consiste à porter son attention sur le moment présent, sans jugement. Cette technique, issue de la tradition bouddhiste, a été adaptée et scientifiquement validée pour ses bienfaits sur la santé mentale et physique.</p>

                                <h2>Les bienfaits prouvés scientifiquement</h2>
                                <p>De nombreuses études ont démontré les effets positifs de la méditation pleine conscience :</p>
                                <ul>
                                    <li><strong>Réduction du stress</strong> : Diminution du cortisol, l'hormone du stress</li>
                                    <li><strong>Amélioration de l'attention</strong> : Meilleure capacité de concentration</li>
                                    <li><strong>Régulation émotionnelle</strong> : Gestion plus sereine des émotions difficiles</li>
                                    <li><strong>Qualité du sommeil</strong> : Endormissement plus facile et sommeil plus réparateur</li>
                                    <li><strong>Réduction de l'anxiété</strong> : Diminution significative des symptômes anxieux</li>
                                </ul>

                                <h2>Comment commencer ?</h2>
                                <p>Commencer la méditation pleine conscience ne nécessite aucun équipement spécial. Voici les étapes pour débuter :</p>

                                <h3>1. Trouvez un endroit calme</h3>
                                <p>Choisissez un espace où vous ne serez pas dérangé. Cela peut être votre chambre, votre salon, ou même un coin de votre bureau.</p>

                                <h3>2. Adoptez une posture confortable</h3>
                                <p>Asseyez-vous confortablement, le dos droit mais pas rigide. Vous pouvez utiliser une chaise ou un coussin de méditation.</p>

                                <h3>3. Commencez par 5 minutes</h3>
                                <p>Inutile de viser des séances longues dès le début. Commencez par 5 minutes par jour et augmentez progressivement.</p>

                                <h2>Exercice pratique : La méditation sur la respiration</h2>
                                <p>Voici un exercice simple pour commencer :</p>
                                <ol>
                                    <li>Fermez les yeux ou fixez un point devant vous</li>
                                    <li>Portez votre attention sur votre respiration naturelle</li>
                                    <li>Quand votre esprit divague, ramenez doucement votre attention sur la respiration</li>
                                    <li>Observez sans juger, avec bienveillance</li>
                                </ol>

                                <h2>Conseils pour une pratique régulière</h2>
                                <p><em>La régularité est plus importante que la durée.</em> Mieux vaut méditer 5 minutes chaque jour que 30 minutes une fois par semaine.</p>

                                <p>Créez un rituel : choisissez un moment fixe dans votre journée, comme le matin au réveil ou le soir avant de vous coucher. Cette routine facilitera l'intégration de la pratique dans votre quotidien.</p>

                                <h2>Conclusion</h2>
                                <p>La méditation pleine conscience est un outil puissant pour améliorer votre qualité de vie. Avec de la patience et de la régularité, vous développerez une relation plus sereine avec vos pensées et émotions, tout en cultivant un état de bien-être durable.</p>
                            `
                        },
                        {
                            id: 2,
                            titre: "Exercices de respiration pour réduire le stress",
                            description: "Maîtrisez différentes techniques de respiration pour gérer votre stress et améliorer votre concentration.",
                            categorie: "Respiration",
                            created_at: "2024-01-12T14:20:00Z",
                            auteur: "Dr. Jean Martin",
                            temps_lecture: 5,
                            contenu: `
                                <h2>Introduction aux exercices de respiration</h2>
                                <p>Les exercices de respiration sont des outils simples et efficaces pour réduire le stress et améliorer votre bien-être général. Ils peuvent être pratiqués n'importe où et à tout moment.</p>

                                <h2>Techniques de respiration</h2>
                                <p>Voici quelques techniques de respiration que vous pouvez essayer :</p>
                                <ul>
                                    <li><strong>Respiration abdominale</strong> : Concentrez-vous sur le mouvement de votre abdomen plutôt que de votre poitrine.</li>
                                    <li><strong>Respiration alternée</strong> : Alternez la respiration entre les narines pour équilibrer les énergies.</li>
                                    <li><strong>Respiration profonde</strong> : Inspirez profondément par le nez et expirez lentement par la bouche.</li>
                                </ul>

                                <h2>Bienfaits des exercices de respiration</h2>
                                <p>Les exercices de respiration offrent de nombreux bienfaits, notamment :</p>
                                <ul>
                                    <li>Réduction du stress et de l'anxiété</li>
                                    <li>Amélioration de la concentration et de la clarté mentale</li>
                                    <li>Renforcement du système immunitaire</li>
                                    <li>Amélioration de la qualité du sommeil</li>
                                </ul>

                                <h2>Conclusion</h2>
                                <p>Intégrez ces exercices de respiration dans votre routine quotidienne pour profiter de leurs nombreux bienfaits. Avec une pratique régulière, vous remarquerez une amélioration significative de votre bien-être général.</p>
                            `
                        },
                        {
                            id: 3,
                            titre: "Yoga matinal : 10 postures pour bien commencer la journée",
                            description: "Réveillez votre corps en douceur avec cette série de postures de yoga spécialement conçues pour le matin. Énergie et vitalité garanties !",
                            categorie: "Yoga",
                            created_at: "2024-01-10T08:00:00Z",
                            auteur: "Yoga Maître Sandrine",
                            temps_lecture: 12,
                            contenu: `
                                <h2>Pourquoi pratiquer le yoga le matin ?</h2>
                                <p>Le matin est le moment idéal pour pratiquer le yoga. Votre corps est reposé, votre esprit est clair, et vous disposez d'un moment de calme avant que la journée ne commence. Une pratique matinale de <strong>15 à 20 minutes</strong> peut transformer votre journée entière.</p>
                                
                                <h2>Les bienfaits du yoga matinal</h2>
                                <ul>
                                    <li><strong>Réveil en douceur</strong> : Éveil progressif du corps et de l'esprit</li>
                                    <li><strong>Énergie naturelle</strong> : Stimulation de la circulation sanguine</li>
                                    <li><strong>Flexibilité</strong> : Assouplissement des muscles et articulations</li>
                                    <li><strong>Clarté mentale</strong> : Amélioration de la concentration</li>
                                    <li><strong>Sérénité</strong> : Gestion du stress dès le réveil</li>
                                </ul>
                                
                                <h2>Préparation de votre pratique</h2>
                                <p>Avant de commencer, préparez votre espace :</p>
                                <ul>
                                    <li>Choisissez un endroit calme et aéré</li>
                                    <li>Utilisez un tapis de yoga antidérapant</li>
                                    <li>Portez des vêtements confortables</li>
                                    <li>Gardez une bouteille d'eau à portée de main</li>
                                </ul>
                                
                                <h2>Séquence de 10 postures matinales</h2>
                                
                                <h3>1. Respiration consciente (Pranayama)</h3>
                                <p>Assis en tailleur, fermez les yeux et prenez 5 respirations profondes. Inspirez par le nez en gonflant le ventre, expirez lentement par la bouche.</p>
                                
                                <h3>2. Étirements du cou</h3>
                                <p>Doucement, inclinez la tête d'un côté puis de l'autre, en maintenant 15 secondes de chaque côté. Effectuez ensuite des rotations lentes.</p>
                                
                                <h3>3. Posture du chat-vache (Marjaryasana-Bitilasana)</h3>
                                <p>À quatre pattes, alternez entre l'arrondi du dos (chat) et le creusement du dos (vache). Répétez 8 fois en synchronisant avec la respiration.</p>
                                
                                <h3>4. Posture de l'enfant (Balasana)</h3>
                                <p>Agenouillez-vous, écartez les genoux et penchez-vous vers l'avant, bras étendus. Restez 1 minute en respirant profondément.</p>
                                
                                <h3>5. Salutation au soleil simplifiée</h3>
                                <p>Enchaînez les mouvements en synchronisant avec la respiration pour réveiller tout le corps en douceur.</p>
                                
                                <h3>6. Posture du guerrier I (Virabhadrasana I)</h3>
                                <p>Jambe droite devant, pliée à 90°, jambe gauche tendue derrière. Bras vers le ciel. Maintenez 30 secondes de chaque côté.</p>
                                
                                <h3>7. Posture du triangle (Trikonasana)</h3>
                                <p>Jambes écartées, penchez-vous vers la droite, main droite vers le sol, bras gauche vers le ciel. Maintenez 30 secondes de chaque côté.</p>
                                
                                <h3>8. Posture de l'arbre (Vrksasana)</h3>
                                <p>Debout, placez le pied droit sur la cuisse gauche, mains jointes devant le cœur. Équilibre pendant 30 secondes de chaque côté.</p>
                                
                                <h3>9. Torsion assise (Ardha Matsyendrasana)</h3>
                                <p>Assis, jambe droite tendue, jambe gauche pliée par-dessus. Tournez le buste vers la gauche en respirant profondément.</p>
                                
                                <h3>10. Relaxation finale (Savasana)</h3>
                                <p>Allongez-vous sur le dos, bras le long du corps, paumes vers le ciel. Relaxez-vous complètement pendant 3 à 5 minutes.</p>
                                
                                <h2>Conseils pour une pratique régulière</h2>
                                <ul>
                                    <li>Commencez par 3 fois par semaine</li>
                                    <li>Écoutez votre corps et adaptez les postures</li>
                                    <li>Maintenez une respiration régulière</li>
                                    <li>Soyez patient avec vous-même</li>
                                </ul>
                                
                                <h2>Conclusion</h2>
                                <p>Cette séquence de yoga matinal vous aidera à commencer chaque journée avec énergie et sérénité. <em>Namaste !</em></p>
                            `
                        },
                        {
                            id: 4,
                            titre: "Alimentation consciente : manger en pleine conscience",
                            description: "Apprenez à redécouvrir le plaisir de manger en développant une relation saine avec la nourriture.",
                            categorie: "Nutrition",
                            created_at: "2024-01-08T16:45:00Z",
                            auteur: "Nutritionniste Laura Blanc",
                            temps_lecture: 7,
                            contenu: `
                                <h2>Qu'est-ce que l'alimentation consciente ?</h2>
                                <p>L'alimentation consciente, ou <strong>mindful eating</strong>, consiste à porter une attention bienveillante à notre expérience alimentaire. C'est une approche qui nous reconnecte avec nos sensations de faim, de satiété et de plaisir.</p>
                                
                                <h2>Les principes fondamentaux</h2>
                                <ul>
                                    <li><strong>Présence</strong> : Être pleinement présent pendant le repas</li>
                                    <li><strong>Conscience</strong> : Observer ses sensations sans jugement</li>
                                    <li><strong>Gratitude</strong> : Apprécier la nourriture et sa préparation</li>
                                    <li><strong>Respect</strong> : Honorer les signaux de son corps</li>
                                </ul>
                                
                                <h2>Exercices pratiques</h2>
                                <h3>L'exercice du raisin sec</h3>
                                <p>Prenez un raisin sec et observez-le pendant 2 minutes avant de le manger très lentement, en notant toutes les sensations.</p>
                                
                                <h3>La règle des 3 bouchées</h3>
                                <p>Concentrez-vous pleinement sur les 3 premières bouchées de chaque repas.</p>
                                
                                <h2>Bénéfices de l'alimentation consciente</h2>
                                <ul>
                                    <li>Amélioration de la digestion</li>
                                    <li>Réduction du stress lié à l'alimentation</li>
                                    <li>Meilleure gestion du poids</li>
                                    <li>Redécouverte du plaisir de manger</li>
                                </ul>
                                
                                <h2>Conseils pour commencer</h2>
                                <p>Commencez par un repas par jour et éteignez tous les écrans pendant que vous mangez.</p>
                            `
                        },
                        {
                            id: 5,
                            titre: "Gestion du sommeil : créer un environnement propice au repos",
                            description: "Transformez votre chambre en sanctuaire du sommeil.",
                            categorie: "Sommeil",
                            created_at: "2024-01-05T19:30:00Z",
                            auteur: "Dr. Sophie Martin",
                            temps_lecture: 9,
                            contenu: `
                                <h2>L'importance d'un bon sommeil</h2>
                                <p>Le sommeil représente environ un tiers de notre vie et joue un rôle crucial dans notre <strong>santé physique et mentale</strong>. Un sommeil de qualité améliore la concentration, renforce le système immunitaire et favorise la récupération.</p>
                                
                                <h2>Optimiser votre environnement de sommeil</h2>
                                
                                <h3>La température idéale</h3>
                                <p>Maintenez votre chambre entre <strong>16 et 19°C</strong>. Une température trop élevée perturbe les cycles du sommeil.</p>
                                
                                <h3>L'obscurité totale</h3>
                                <p>Utilisez des rideaux occultants ou un masque de sommeil. La moindre source de lumière peut perturber la production de mélatonine.</p>
                                
                                <h3>Le silence</h3>
                                <p>Éliminez les bruits parasites avec des bouchons d'oreilles ou un générateur de bruit blanc.</p>
                                
                                <h2>Rituels du coucher</h2>
                                <ul>
                                    <li>Arrêtez les écrans 1h avant le coucher</li>
                                    <li>Prenez une douche tiède</li>
                                    <li>Pratiquez la lecture ou la méditation</li>
                                    <li>Maintenez des horaires réguliers</li>
                                </ul>
                                
                                <h2>Techniques de relaxation</h2>
                                <h3>La respiration 4-7-8</h3>
                                <p>Inspirez 4 secondes, retenez 7 secondes, expirez 8 secondes. Répétez 4 fois.</p>
                                
                                <h3>La relaxation musculaire progressive</h3>
                                <p>Contractez puis relâchez chaque groupe musculaire en commençant par les pieds.</p>
                                
                                <h2>Conclusion</h2>
                                <p>Un environnement de sommeil optimal est la clé d'un repos réparateur. <em>Bonne nuit !</em></p>
                            `
                        },
                        {
                            id: 6,
                            titre: "Méditation guidée : voyage intérieur de 20 minutes",
                            description: "Laissez-vous guider dans un voyage de détente profonde avec cette méditation audio.",
                            categorie: "Méditation",
                            created_at: "2024-01-03T11:15:00Z",
                            auteur: "Sophie Laurent",
                            temps_lecture: 10,
                            contenu: `
                                <h2>Introduction à la méditation guidée</h2>
                                <p>La méditation guidée est une pratique où une voix vous guide à travers un voyage de détente et de découverte intérieure. C'est un excellent moyen de se détendre et de se recentrer.</p>

                                <h2>Bienfaits de la méditation guidée</h2>
                                <p>La méditation guidée offre de nombreux bienfaits, notamment :</p>
                                <ul>
                                    <li>Réduction du stress et de l'anxiété</li>
                                    <li>Amélioration de la concentration et de la clarté mentale</li>
                                    <li>Renforcement du système immunitaire</li>
                                    <li>Amélioration de la qualité du sommeil</li>
                                </ul>

                                <h2>Comment pratiquer la méditation guidée</h2>
                                <p>Pour pratiquer la méditation guidée, trouvez un endroit calme où vous ne serez pas dérangé. Asseyez-vous confortablement et suivez les instructions de la voix guide.</p>

                                <h2>Exercice de méditation guidée</h2>
                                <p>Voici un exercice simple pour commencer :</p>
                                <ol>
                                    <li>Fermez les yeux et concentrez-vous sur votre respiration.</li>
                                    <li>Écoutez attentivement la voix guide et suivez ses instructions.</li>
                                    <li>Laissez-vous guider à travers un voyage de détente et de découverte intérieure.</li>
                                    <li>À la fin de la méditation, prenez un moment pour vous recentrer et revenir à l'instant présent.</li>
                                </ol>

                                <h2>Conclusion</h2>
                                <p>La méditation guidée est un outil puissant pour améliorer votre bien-être général. Avec une pratique régulière, vous remarquerez une amélioration significative de votre qualité de vie.</p>
                            `
                        }
                    ],
                    categories: []
                };
            },
            computed: {
                filteredArticles() {
                    return this.articles.filter(article => {
                        const matchesSearch = !this.searchQuery ||
                            article.titre.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            article.description.toLowerCase().includes(this.searchQuery.toLowerCase());
                        const matchesCategory = !this.selectedCategory ||
                            article.categorie === this.selectedCategory;
                        return matchesSearch && matchesCategory;
                    });
                },
                paginatedArticles() {
                    const start = 0;
                    const end = this.currentPage * this.articlesPerPage;
                    return this.filteredArticles.slice(start, end);
                }
            },
            methods: {
                formatDate(dateString) {
                    if (!dateString) return '';
                    const date = new Date(dateString);
                    return date.toLocaleDateString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                },
                consultArticle(article) {
                    this.selectedArticle = article;
                    this.showModal = true;
                },
                closeModal() {
                    this.showModal = false;
                    this.selectedArticle = null;
                }
            },
            mounted() {
                this.categories = [...new Set(this.articles.map(article => article.categorie))];
            }
        }).mount('#app');
    </script>
</body>
</html>
