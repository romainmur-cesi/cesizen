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
    </style>
</head>
<body class="bg-gray-50">
    <div id="app" class="container mx-auto px-4 py-8">
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
                    <button class="btn-gradient text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md">
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

    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    searchQuery: '',
                    selectedCategory: '',
                    currentPage: 1,
                    articlesPerPage: 6,
                    articles: [
                        {
                            id: 1,
                            titre: "Introduction à la méditation pleine conscience",
                            description: "Découvrez les bases de la méditation pleine conscience pour améliorer votre bien-être quotidien.",
                            categorie: "Méditation",
                            created_at: "2024-01-15T10:30:00Z"
                        },
                        {
                            id: 2,
                            titre: "Exercices de respiration pour réduire le stress",
                            description: "Maîtrisez différentes techniques de respiration pour gérer votre stress et améliorer votre concentration.",
                            categorie: "Respiration",
                            created_at: "2024-01-12T14:20:00Z"
                        },
                        {
                            id: 3,
                            titre: "Yoga matinal : 10 postures pour bien commencer la journée",
                            description: "Réveillez votre corps en douceur avec cette série de postures de yoga spécialement conçues pour le matin.",
                            categorie: "Yoga",
                            created_at: "2024-01-10T08:00:00Z"
                        },
                        {
                            id: 4,
                            titre: "Alimentation consciente : manger en pleine conscience",
                            description: "Apprenez à redécouvrir le plaisir de manger en développant une relation saine avec la nourriture.",
                            categorie: "Nutrition",
                            created_at: "2024-01-08T16:45:00Z"
                        },
                        {
                            id: 5,
                            titre: "Gestion du sommeil : créer un environnement propice au repos",
                            description: "Transformez votre chambre en sanctuaire du sommeil.",
                            categorie: "Sommeil",
                            created_at: "2024-01-05T19:30:00Z"
                        },
                        {
                            id: 6,
                            titre: "Méditation guidée : voyage intérieur de 20 minutes",
                            description: "Laissez-vous guider dans un voyage de détente profonde avec cette méditation audio.",
                            categorie: "Méditation",
                            created_at: "2024-01-03T11:15:00Z"
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
                    alert(`Ouverture de l'article : "${article.titre}"\n\nEn production, ceci redirigerait vers la page détaillée de l'article.`);
                }
            },
            mounted() {
                this.categories = [...new Set(this.articles.map(article => article.categorie))];
            }
        }).mount('#app');
    </script>
</body>
</html>