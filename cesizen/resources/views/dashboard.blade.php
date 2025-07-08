<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Gestion Administrateurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.4/vue.global.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .tab-btn-separated {
            margin-right: 10px; /* Ajoute une marge à droite */
        }
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
        .btn-danger {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }
        .btn-danger:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
        }
        .btn-edit {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }
        .btn-edit:hover {
            background: linear-gradient(135deg, #2980b9, #1f639a);
        }
        .status-badge {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
        }
        .status-badge.inactive {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
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
        .navbar {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            box-shadow: 0 4px 20px rgba(46, 204, 113, 0.3);
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
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
        }
        .stats-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border: 1px solid #e9ecef;
        }
        .stats-icon {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
        }
        .tab-btn {
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }
        .tab-btn.active {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            border-bottom: 3px solid #f1c40f;
        }
        .tab-btn:not(.active) {
            background: white;
            color: #27ae60;
            border: 2px solid #27ae60;
        }
        .tab-btn:not(.active):hover {
            background: rgba(39, 174, 96, 0.1);
        }
        .article-form textarea {
            min-height: 200px;
            resize: vertical;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation simulée -->
    <nav class="navbar p-4 mb-8">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-white text-xl font-bold">
                <i class="fas fa-user-shield mr-2"></i>
                Admin CESIZen
            </div>
            <div class="flex items-center gap-4 text-white">
                <div class="flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    Super Admin
                </div>
                <button
                    onclick="window.location.href='/login'"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                >
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Déconnexion
                </button>
            </div>
        </div>
    </nav>
    <div id="app" class="container mx-auto px-4 py-8">
        <!-- Modal Ajouter/Éditer Article -->
        <div v-if="showArticleModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay" @click="closeArticleModal">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl mx-4 modal-content" @click.stop>
                <div class="p-6 border-b">
                    <h2 class="text-2xl font-bold gradient-text mb-2">
                        @{{ editingArticle ? 'Modifier l\'article' : 'Ajouter un article' }}
                    </h2>
                    <p class="text-gray-600">@{{ editingArticle ? 'Modifiez cet article' : 'Créez un nouvel article' }}</p>
                </div>
                <form @submit.prevent="saveArticle" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-heading mr-1"></i>Titre
                            </label>
                            <input
                                v-model="articleForm.titre"
                                type="text"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Titre de l'article"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tags mr-1"></i>Catégorie
                            </label>
                            <select
                                v-model="articleForm.categorie"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            >
                                <option value="">Sélectionner une catégorie</option>
                                <option value="Méditation">Méditation</option>
                                <option value="Bien-être">Bien-être</option>
                                <option value="Relaxation">Relaxation</option>
                                <option value="Mindfulness">Mindfulness</option>
                                <option value="Yoga">Yoga</option>
                                <option value="Nutrition">Nutrition</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clock mr-1"></i>Temps de lecture (min)
                            </label>
                            <input
                                v-model="articleForm.temps_lecture"
                                type="number"
                                min="1"
                                max="60"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="5"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user-edit mr-1"></i>Auteur
                            </label>
                            <input
                                v-model="articleForm.auteur"
                                type="text"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Nom de l'auteur"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-toggle-on mr-1"></i>Statut
                            </label>
                            <select
                                v-model="articleForm.statut"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            >
                                <option value="publié">Publié</option>
                                <option value="brouillon">Brouillon</option>
                                <option value="archivé">Archivé</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-1"></i>Description
                            </label>
                            <textarea
                                v-model="articleForm.description"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Description courte de l'article..."
                                rows="3"
                            ></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-file-alt mr-1"></i>Contenu
                            </label>
                            <textarea
                                v-model="articleForm.contenu"
                                required
                                class="article-form form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Contenu complet de l'article..."
                            ></textarea>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Vous pouvez utiliser du HTML pour formater votre contenu
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-6 border-t">
                        <button
                            type="button"
                            @click="closeArticleModal"
                            class="px-6 py-3 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors"
                        >
                            Annuler
                        </button>
                        <button
                            type="submit"
                            class="btn-gradient text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                        >
                            <i class="fas fa-save mr-2"></i>
                            @{{ editingArticle ? 'Modifier' : 'Publier' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal Confirmation Suppression Article -->
        <div v-if="showDeleteArticleModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay" @click="closeDeleteArticleModal">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4" @click.stop>
                <div class="p-6 text-center">
                    <div class="text-red-500 text-4xl mb-4">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Confirmer la suppression</h3>
                    <p class="text-gray-600 mb-6">
                        Êtes-vous sûr de vouloir supprimer l'article <strong>@{{ articleToDelete?.titre }}</strong> ?
                        Cette action est irréversible.
                    </p>
                    <div class="flex justify-center gap-3">
                        <button
                            @click="closeDeleteArticleModal"
                            class="px-6 py-3 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors"
                        >
                            Annuler
                        </button>
                        <button
                            @click="confirmDeleteArticle"
                            class="btn-danger text-white px-6 py-3 rounded-lg font-medium transition-all duration-300"
                        >
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay" @click="closeModal">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 modal-content" @click.stop>
                <div class="p-6 border-b">
                    <h2 class="text-2xl font-bold gradient-text mb-2">
                        @{{ editingAdmin ? 'Modifier l\'administrateur' : 'Ajouter un administrateur' }}
                    </h2>
                    <p class="text-gray-600">@{{ editingAdmin ? 'Modifiez les informations de cet administrateur' : 'Créez un nouveau compte administrateur' }}</p>
                </div>
                <form @submit.prevent="saveAdmin" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-1"></i>Nom
                            </label>
                            <input
                                v-model="adminForm.nom"
                                type="text"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-1"></i>Prénom
                            </label>
                            <input
                                v-model="adminForm.prenom"
                                type="text"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-1"></i>Email
                            </label>
                            <input
                                v-model="adminForm.email"
                                type="email"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            />
                        </div>
                        <div v-if="!editingAdmin" class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-1"></i>Mot de passe
                            </label>
                            <input
                                v-model="adminForm.password"
                                type="password"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-shield-alt mr-1"></i>Rôle
                            </label>
                            <select
                                v-model="adminForm.role"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            >
                                <option value="admin">Administrateur</option>
                                <option value="super_admin">Super Administrateur</option>
                                <option value="moderateur">Modérateur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-toggle-on mr-1"></i>Statut
                            </label>
                            <select
                                v-model="adminForm.statut"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            >
                                <option value="actif">Actif</option>
                                <option value="inactif">Inactif</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-6 border-t">
                        <button
                            type="button"
                            @click="closeModal"
                            class="px-6 py-3 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors"
                        >
                            Annuler
                        </button>
                        <button
                            type="submit"
                            class="btn-gradient text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                        >
                            <i class="fas fa-save mr-2"></i>
                            @{{ editingAdmin ? 'Modifier' : 'Ajouter' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal Confirmation Suppression -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay" @click="closeDeleteModal">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4" @click.stop>
                <div class="p-6 text-center">
                    <div class="text-red-500 text-4xl mb-4">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Confirmer la suppression</h3>
                    <p class="text-gray-600 mb-6">
                        Êtes-vous sûr de vouloir supprimer l'administrateur <strong>@{{ adminToDelete?.nom }} @{{ adminToDelete?.prenom }}</strong> ?
                        Cette action est irréversible.
                    </p>
                    <div class="flex justify-center gap-3">
                        <button
                            @click="closeDeleteModal"
                            class="px-6 py-3 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors"
                        >
                            Annuler
                        </button>
                        <button
                            @click="confirmDelete"
                            class="btn-danger text-white px-6 py-3 rounded-lg font-medium transition-all duration-300"
                        >
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Ajouter/Éditer Exercice -->
        <div v-if="showExerciceModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay" @click="closeExerciceModal">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl mx-4 modal-content" @click.stop>
                <div class="p-6 border-b">
                    <h2 class="text-2xl font-bold gradient-text mb-2">
                        @{{ editingExercice ? 'Modifier l\'exercice' : 'Ajouter un exercice' }}
                    </h2>
                    <p class="text-gray-600">@{{ editingExercice ? 'Modifiez cet exercice' : 'Créez un nouvel exercice' }}</p>
                </div>
                <form @submit.prevent="saveExercice" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-heading mr-1"></i>Titre
                            </label>
                            <input
                                v-model="exerciceForm.titre"
                                type="text"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Titre de l'exercice"
                            />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-1"></i>Description
                            </label>
                            <textarea
                                v-model="exerciceForm.description"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Description de l'exercice..."
                                rows="3"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clock mr-1"></i>Durée (min)
                            </label>
                            <input
                                v-model="exerciceForm.duree"
                                type="number"
                                min="1"
                                max="60"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="5"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-toggle-on mr-1"></i>Statut
                            </label>
                            <select
                                v-model="exerciceForm.statut"
                                required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            >
                                <option value="publié">Publié</option>
                                <option value="archivé">Archivé</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-6 border-t">
                        <button
                            type="button"
                            @click="closeExerciceModal"
                            class="px-6 py-3 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors"
                        >
                            Annuler
                        </button>
                        <button
                            type="submit"
                            class="btn-gradient text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                        >
                            <i class="fas fa-save mr-2"></i>
                            @{{ editingExercice ? 'Modifier' : 'Publier' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Confirmation Suppression Exercice -->
        <div v-if="showDeleteExerciceModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay" @click="closeDeleteExerciceModal">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4" @click.stop>
                <div class="p-6 text-center">
                    <div class="text-red-500 text-4xl mb-4">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Confirmer la suppression</h3>
                    <p class="text-gray-600 mb-6">
                        Êtes-vous sûr de vouloir supprimer l'exercice <strong>@{{ exerciceToDelete?.titre }}</strong> ?
                        Cette action est irréversible.
                    </p>
                    <div class="flex justify-center gap-3">
                        <button
                            @click="closeDeleteExerciceModal"
                            class="px-6 py-3 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors"
                        >
                            Annuler
                        </button>
                        <button
                            @click="confirmDeleteExercice"
                            class="btn-danger text-white px-6 py-3 rounded-lg font-medium transition-all duration-300"
                        >
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold gradient-text mb-2">
                <i class="fas fa-cog mr-3"></i>
                Panneau d'Administration
            </h1>
            <p class="text-gray-600 text-lg">Gérez votre plateforme CESIZen</p>
        </div>
        <!-- Navigation par onglets -->
        <div class="flex justify-center mb-8">
            <div class="flex bg-gray-100 rounded-lg p-1">
                <button
                    @click="activeTab = 'admins'"
                    :class="['tab-btn', 'px-6', 'py-3', 'rounded-lg', 'font-medium', 'flex', 'items-center', 'gap-2', 'tab-btn-separated', { 'active': activeTab === 'admins' }]"
                >
                    <i class="fas fa-users-cog"></i>
                    Administrateurs
                </button>
                <button
                    @click="activeTab = 'articles'"
                    :class="['tab-btn', 'px-6', 'py-3', 'rounded-lg', 'font-medium', 'flex', 'items-center', 'gap-2', 'tab-btn-separated', { 'active': activeTab === 'articles' }]"
                >
                    <i class="fas fa-newspaper"></i>
                    Articles
                </button>
                <button
                    @click="activeTab = 'exercices'"
                    :class="['tab-btn', 'px-6', 'py-3', 'rounded-lg', 'font-medium', 'flex', 'items-center', 'gap-2', { 'active': activeTab === 'exercices' }]"
                >
                    <i class="fas fa-lungs"></i>
                    Exercices de Respiration
                </button>
            </div>
        </div>
        <!-- Contenu basé sur l'onglet actif -->
        <div v-if="activeTab === 'admins'">
            <!-- Gestion des Administrateurs -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Admins</p>
                            <p class="text-2xl font-bold text-gray-800"> @{{ admins.length }}</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-user-check text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Actifs</p>
                            <p class="text-2xl font-bold text-green-600">@{{ admins.filter(a => a.statut === 'actif').length }}</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-user-times text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Inactifs</p>
                            <p class="text-2xl font-bold text-red-600">@{{ admins.filter(a => a.statut === 'inactif').length }}</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-crown text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Super Admins</p>
                            <p class="text-2xl font-bold text-yellow-600">@{{ admins.filter(a => a.role === 'super_admin').length }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recherche, Filtre et Bouton Ajouter -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row gap-4 mb-4">
                    <div class="flex-1">
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Rechercher par nom, prénom ou email..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        />
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button
                            @click="selectedRole = ''"
                            :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedRole === '' }]"
                        >
                            Tous les rôles
                        </button>
                        <button
                            @click="selectedRole = 'super_admin'"
                            :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedRole === 'super_admin' }]"
                        >
                            Super Admin
                        </button>
                        <button
                            @click="selectedRole = 'admin'"
                            :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedRole === 'admin' }]"
                        >
                            Admin
                        </button>
                        <button
                            @click="selectedRole = 'moderateur'"
                            :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedRole === 'moderateur' }]"
                        >
                            Modérateur
                        </button>
                    </div>
                    <button
                        @click="openAddModal"
                        class="btn-gradient text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                    >
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter Admin
                    </button>
                </div>
            </div>
            <!-- Statistiques filtrées -->
            <div class="mb-6 text-center">
                <p class="text-gray-600">
                    <span class="font-semibold text-green-600">@{{ filteredAdmins.length }}</span>
                    administrateur@{{ filteredAdmins.length > 1 ? 's' : '' }}
                    @{{ selectedRole ? `avec le rôle "${getRoleLabel(selectedRole)}"` : 'au total' }}
                </p>
            </div>
            <!-- Liste des Administrateurs -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <div
                    v-for="admin in filteredAdmins"
                    :key="admin.id"
                    class="bg-white rounded-xl shadow-lg p-6 transition-all duration-300 card-hover border border-gray-200"
                >
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="bg-gradient-to-r from-green-400 to-green-600 p-3 rounded-full mr-4">
                                <i class="fas fa-user-shield text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">
                                    @{{ admin.nom }} @{{ admin.prenom }}
                                </h3>
                                <p class="text-gray-600">@{{ admin.email }}</p>
                            </div>
                        </div>
                        <span :class="['status-badge', 'text-white', 'px-3', 'py-1', 'rounded-full', 'text-sm', 'font-medium', { 'inactive': admin.statut === 'inactif' }]">
                            @{{ admin.statut === 'actif' ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-shield-alt mr-2 text-green-600"></i>
                            <span class="font-medium">@{{ getRoleLabel(admin.role) }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Créé le @{{ formatDate(admin.created_at) }}
                        </div>
                    </div>
                    <div class="flex justify-between pt-4 border-t border-gray-200">
                        <button
                            @click="editAdmin(admin)"
                            class="btn-edit text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                        >
                            <i class="fas fa-edit mr-1"></i>
                            Modifier
                        </button>
                        <button
                            @click="openDeleteModal(admin)"
                            class="btn-danger text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                        >
                            <i class="fas fa-trash mr-1"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
            <div v-if="filteredAdmins.length === 0" class="text-center py-12">
                <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-600 text-lg">Aucun administrateur trouvé</p>
                <p class="text-gray-500">Essayez de modifier vos critères de recherche</p>
            </div>
        </div>
        <!-- Gestion des Articles -->
        <div v-if="activeTab === 'articles'">
            <!-- Statistiques Articles -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-newspaper text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Articles</p>
                            <p class="text-2xl font-bold text-gray-800">@{{ articles.length }}</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-eye text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Publiés</p>
                            <p class="text-2xl font-bold text-green-600">@{{ articles.filter(a => a.statut === 'publié').length }}</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-edit text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Brouillons</p>
                            <p class="text-2xl font-bold text-yellow-600">@{{ articles.filter(a => a.statut === 'brouillon').length }}</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-archive text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Archivés</p>
                            <p class="text-2xl font-bold text-red-600">@{{ articles.filter(a => a.statut === 'archivé').length }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recherche, Filtre et Bouton Ajouter Article -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row gap-4 mb-4">
                    <div class="flex-1">
                        <input
                            v-model="searchArticleQuery"
                            type="text"
                            placeholder="Rechercher par titre, auteur ou catégorie..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        />
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button
                            @click="selectedArticleCategory = ''"
                            :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedArticleCategory === '' }]"
                        >
                            Toutes
                        </button>
                        <button
                            v-for="category in articleCategories"
                            :key="category"
                            @click="selectedArticleCategory = category"
                            :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedArticleCategory === category }]"
                        >
                            @{{ category }}
                        </button>
                    </div>
                    <button
                        @click="openAddArticleModal"
                        class="btn-gradient text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                    >
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter Article
                    </button>
                </div>
            </div>
            <!-- Statistiques filtrées articles -->
            <div class="mb-6 text-center">
                <p class="text-gray-600">
                    <span class="font-semibold text-green-600">@{{ filteredArticles.length }}</span>
                    article@{{ filteredArticles.length > 1 ? 's' : '' }}
                    @{{ selectedArticleCategory ? `dans la catégorie "${selectedArticleCategory}"` : 'au total' }}
                </p>
            </div>
            <!-- Liste des Articles -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <div
                    v-for="article in filteredArticles"
                    :key="article.id"
                    class="bg-white rounded-xl shadow-lg p-6 transition-all duration-300 card-hover border border-gray-200"
                >
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">
                                @{{ article.titre }}
                            </h3>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="category-badge text-white px-3 py-1 rounded-full text-sm font-medium">
                                    @{{ article.categorie }}
                                </span>
                                <span :class="['text-white', 'px-3', 'py-1', 'rounded-full', 'text-sm', 'font-medium',
                                    article.statut === 'publié' ? 'bg-green-500' :
                                    article.statut === 'brouillon' ? 'bg-yellow-500' : 'bg-red-500']">
                                    @{{ article.statut }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                        @{{ article.description }}
                    </p>

                    <div class="mb-4">
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-1"></i>
                                @{{ article.auteur }}
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                @{{ article.temps_lecture }} min
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 mt-1">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            @{{ formatDate(article.created_at) }}
                        </div>
                    </div>
                    <div class="flex justify-between pt-4 border-t border-gray-200">
                        <button
                            @click="editArticle(article)"
                            class="btn-edit text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                        >
                            <i class="fas fa-edit mr-1"></i>
                            Modifier
                        </button>
                        <button
                            @click="openDeleteArticleModal(article)"
                            class="btn-danger text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                        >
                            <i class="fas fa-trash mr-1"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
            <!-- Aucun article trouvé -->
            <div v-if="filteredArticles.length === 0" class="text-center py-12">
                <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-600 text-lg">Aucun article trouvé</p>
                <p class="text-gray-500">Essayez de modifier vos critères de recherche</p>
            </div>
        </div>
        <!-- Gestion des Exercices de Respiration -->
        <div v-if="activeTab === 'exercices'">
            <!-- Statistiques Exercices -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-lungs text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Exercices</p>
                            <p class="text-2xl font-bold text-gray-800">@{{ exercices.length }}</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-eye text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Publiés</p>
                            <p class="text-2xl font-bold text-green-600">@{{ exercices.filter(e => e.statut === 'publié').length }}</p>
                        </div>
                    </div>
                </div>
                <div class="stats-card rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
                    <div class="flex items-center">
                        <div class="stats-icon p-3 rounded-full mr-4">
                            <i class="fas fa-archive text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Archivés</p>
                            <p class="text-2xl font-bold text-red-600">@{{ exercices.filter(e => e.statut === 'archivé').length }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recherche, Filtre et Bouton Ajouter Exercice -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row gap-4 mb-4">
                    <div class="flex-1">
                        <input
                            v-model="searchExerciceQuery"
                            type="text"
                            placeholder="Rechercher par titre ou description..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        />
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button
                            @click="selectedExerciceStatus = ''"
                            :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedExerciceStatus === '' }]"
                        >
                            Tous
                        </button>
                        <button
                            @click="selectedExerciceStatus = 'publié'"
                            :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedExerciceStatus === 'publié' }]"
                        >
                            Publié
                        </button>
                        <button
                            @click="selectedExerciceStatus = 'archivé'"
                            :class="['filter-btn', 'px-4', 'py-2', 'rounded-lg', 'font-medium', { 'active': selectedExerciceStatus === 'archivé' }]"
                        >
                            Archivé
                        </button>
                    </div>
                    <button
                        @click="openAddExerciceModal"
                        class="btn-gradient text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                    >
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter Exercice
                    </button>
                </div>
            </div>
            <!-- Statistiques filtrées exercices -->
            <div class="mb-6 text-center">
                <p class="text-gray-600">
                    <span class="font-semibold text-green-600">@{{ filteredExercices.length }}</span>
                    exercice@{{ filteredExercices.length > 1 ? 's' : '' }}
                    @{{ selectedExerciceStatus ? `avec le statut "${selectedExerciceStatus}"` : 'au total' }}
                </p>
            </div>
            <!-- Liste des Exercices -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <div
                    v-for="exercice in filteredExercices"
                    :key="exercice.id"
                    class="bg-white rounded-xl shadow-lg p-6 transition-all duration-300 card-hover border border-gray-200"
                >
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">
                                @{{ exercice.titre }}
                            </h3>
                            <div class="flex items-center gap-2 mb-2">
                                <span :class="['text-white', 'px-3', 'py-1', 'rounded-full', 'text-sm', 'font-medium',
                                    exercice.statut === 'publié' ? 'bg-green-500' : 'bg-red-500']">
                                    @{{ exercice.statut }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                        @{{ exercice.description }}
                    </p>

                    <div class="mb-4">
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                @{{ exercice.duree }} min
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 mt-1">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            @{{ formatDate(exercice.created_at) }}
                        </div>
                    </div>
                    <div class="flex justify-between pt-4 border-t border-gray-200">
                        <button
                            @click="editExercice(exercice)"
                            class="btn-edit text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                        >
                            <i class="fas fa-edit mr-1"></i>
                            Modifier
                        </button>
                        <button
                            @click="openDeleteExerciceModal(exercice)"
                            class="btn-danger text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 hover:transform hover:-translate-y-1 hover:shadow-md"
                        >
                            <i class="fas fa-trash mr-1"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
            <!-- Aucun exercice trouvé -->
            <div v-if="filteredExercices.length === 0" class="text-center py-12">
                <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-600 text-lg">Aucun exercice trouvé</p>
                <p class="text-gray-500">Essayez de modifier vos critères de recherche</p>
            </div>
        </div>
    </div>
    <script>
        const { createApp } = Vue;
        createApp({
            data() {
                return {
                    admins: [
                        {
                            id: 1,
                            nom: 'Admin',
                            prenom: 'Admin',
                            email: 'admin@exemple.com',
                            role: 'super_admin',
                            statut: 'actif',
                            created_at: '2024-01-15T10:00:00Z'
                        },
                        {
                            id: 2,
                            nom: 'Martin',
                            prenom: 'Marie',
                            email: 'marie.martin@cesizen.com',
                            role: 'admin',
                            statut: 'actif',
                            created_at: '2024-02-20T14:30:00Z'
                        },
                        {
                            id: 3,
                            nom: 'Leroy',
                            prenom: 'Paul',
                            email: 'paul.leroy@cesizen.com',
                            role: 'moderateur',
                            statut: 'inactif',
                            created_at: '2024-03-10T09:15:00Z'
                        }
                    ],
                    articles: [
                        {
                            id: 1,
                            titre: 'Les bienfaits de la méditation quotidienne',
                            description: 'Découvrez comment la méditation peut transformer votre quotidien et améliorer votre bien-être mental et physique.',
                            contenu: '<h2>Introduction</h2><p>La méditation est une pratique millénaire qui gagne en popularité dans notre société moderne...</p><h3>Les bienfaits principaux</h3><ul><li>Réduction du stress</li><li>Amélioration de la concentration</li><li>Meilleur sommeil</li></ul>',
                            categorie: 'Méditation',
                            auteur: 'Dr. Marie Dubois',
                            temps_lecture: 8,
                            statut: 'publié',
                            created_at: '2024-03-15T10:00:00Z'
                        },
                        {
                            id: 2,
                            titre: 'Yoga pour débutants : premiers pas',
                            description: 'Un guide complet pour commencer le yoga en douceur, avec des postures simples et efficaces.',
                            contenu: '<h2>Commencer le yoga</h2><p>Le yoga est accessible à tous, quel que soit votre niveau de forme physique...</p>',
                            categorie: 'Yoga',
                            auteur: 'Sophie Martin',
                            temps_lecture: 12,
                            statut: 'brouillon',
                            created_at: '2024-03-20T14:30:00Z'
                        },
                        {
                            id: 3,
                            titre: 'Alimentation mindful : manger en pleine conscience',
                            description: 'Apprenez à développer une relation saine avec la nourriture grâce à la pleine conscience.',
                            contenu: '<h2>Qu\'est-ce que l\'alimentation mindful ?</h2><p>L\'alimentation en pleine conscience nous invite à porter attention...</p>',
                            categorie: 'Nutrition',
                            auteur: 'Thomas Leroy',
                            temps_lecture: 6,
                            statut: 'archivé',
                            created_at: '2024-02-10T09:15:00Z'
                        }
                    ],
                    exercices: [
                        {
                            id: 1,
                            titre: 'Respiration 4-7-8',
                            description: 'Technique de relaxation profonde pour réduire le stress.',
                            duree: 5,
                            statut: 'publié',
                            created_at: '2024-03-10T09:00:00Z'
                        },
                        {
                            id: 2,
                            titre: 'Cohérence cardiaque',
                            description: 'Rythme 5-5-5 pour harmoniser le système nerveux.',
                            duree: 3,
                            statut: 'publié',
                            created_at: '2024-03-12T11:00:00Z'
                        },
                        {
                            id: 3,
                            titre: 'Box Breathing',
                            description: 'Technique militaire pour la concentration.',
                            duree: 4,
                            statut: 'publié',
                            created_at: '2024-03-18T15:00:00Z'
                        }
                    ],
                    activeTab: 'admins',
                    searchQuery: '',
                    selectedRole: '',
                    searchArticleQuery: '',
                    selectedArticleCategory: '',
                    searchExerciceQuery: '',
                    selectedExerciceStatus: '',
                    showModal: false,
                    showDeleteModal: false,
                    showArticleModal: false,
                    showDeleteArticleModal: false,
                    showExerciceModal: false,
                    showDeleteExerciceModal: false,
                    editingAdmin: null,
                    editingArticle: null,
                    editingExercice: null,
                    adminToDelete: null,
                    articleToDelete: null,
                    exerciceToDelete: null,
                    adminForm: {
                        nom: '',
                        prenom: '',
                        email: '',
                        password: '',
                        role: 'admin',
                        statut: 'actif'
                    },
                    articleForm: {
                        titre: '',
                        description: '',
                        contenu: '',
                        categorie: '',
                        auteur: '',
                        temps_lecture: 5,
                        statut: 'publié'
                    },
                    exerciceForm: {
                        titre: '',
                        description: '',
                        duree: 5,
                        statut: 'publié'
                    }
                };
            },
            computed: {
                filteredAdmins() {
                    let filtered = this.admins;
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(admin =>
                            admin.nom.toLowerCase().includes(query) ||
                            admin.prenom.toLowerCase().includes(query) ||
                            admin.email.toLowerCase().includes(query)
                        );
                    }
                    if (this.selectedRole) {
                        filtered = filtered.filter(admin => admin.role === this.selectedRole);
                    }
                    return filtered;
                },
                filteredArticles() {
                    let filtered = this.articles;
                    if (this.searchArticleQuery) {
                        const query = this.searchArticleQuery.toLowerCase();
                        filtered = filtered.filter(article =>
                            article.titre.toLowerCase().includes(query) ||
                            article.auteur.toLowerCase().includes(query) ||
                            article.categorie.toLowerCase().includes(query)
                        );
                    }
                    if (this.selectedArticleCategory) {
                        filtered = filtered.filter(article => article.categorie === this.selectedArticleCategory);
                    }
                    return filtered;
                },
                filteredExercices() {
                    let filtered = this.exercices;
                    if (this.searchExerciceQuery) {
                        const query = this.searchExerciceQuery.toLowerCase();
                        filtered = filtered.filter(exercice =>
                            exercice.titre.toLowerCase().includes(query) ||
                            exercice.description.toLowerCase().includes(query)
                        );
                    }
                    if (this.selectedExerciceStatus) {
                        filtered = filtered.filter(exercice => exercice.statut === this.selectedExerciceStatus);
                    }
                    return filtered;
                },
                articleCategories() {
                    return [...new Set(this.articles.map(article => article.categorie))];
                }
            },
            methods: {
                formatDate(dateString) {
                    return new Date(dateString).toLocaleDateString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                },
                getRoleLabel(role) {
                    const labels = {
                        'super_admin': 'Super Administrateur',
                        'admin': 'Administrateur',
                        'moderateur': 'Modérateur'
                    };
                    return labels[role] || role;
                },
                openAddModal() {
                    this.editingAdmin = null;
                    this.adminForm = {
                        nom: '',
                        prenom: '',
                        email: '',
                        password: '',
                        role: 'admin',
                        statut: 'actif'
                    };
                    this.showModal = true;
                },
                editAdmin(admin) {
                    this.editingAdmin = admin;
                    this.adminForm = {
                        nom: admin.nom,
                        prenom: admin.prenom,
                        email: admin.email,
                        password: '',
                        role: admin.role,
                        statut: admin.statut
                    };
                    this.showModal = true;
                },
                saveAdmin() {
                    if (this.editingAdmin) {
                        const index = this.admins.findIndex(a => a.id === this.editingAdmin.id);
                        if (index !== -1) {
                            this.admins[index] = {
                                ...this.admins[index],
                                nom: this.adminForm.nom,
                                prenom: this.adminForm.prenom,
                                email: this.adminForm.email,
                                role: this.adminForm.role,
                                statut: this.adminForm.statut
                            };
                        }
                    } else {
                        const newAdmin = {
                            id: Math.max(...this.admins.map(a => a.id)) + 1,
                            nom: this.adminForm.nom,
                            prenom: this.adminForm.prenom,
                            email: this.adminForm.email,
                            role: this.adminForm.role,
                            statut: this.adminForm.statut,
                            created_at: new Date().toISOString()
                        };
                        this.admins.push(newAdmin);
                    }
                    this.closeModal();
                },
                openDeleteModal(admin) {
                    this.adminToDelete = admin;
                    this.showDeleteModal = true;
                },
                confirmDelete() {
                    if (this.adminToDelete) {
                        const index = this.admins.findIndex(a => a.id === this.adminToDelete.id);
                        if (index !== -1) {
                            this.admins.splice(index, 1);
                        }
                    }
                    this.closeDeleteModal();
                },
                closeModal() {
                    this.showModal = false;
                    this.editingAdmin = null;
                },
                closeDeleteModal() {
                    this.showDeleteModal = false;
                    this.adminToDelete = null;
                },
                openAddArticleModal() {
                    this.editingArticle = null;
                    this.articleForm = {
                        titre: '',
                        description: '',
                        contenu: '',
                        categorie: '',
                        auteur: '',
                        temps_lecture: 5,
                        statut: 'publié'
                    };
                    this.showArticleModal = true;
                },
                editArticle(article) {
                    this.editingArticle = article;
                    this.articleForm = {
                        titre: article.titre,
                        description: article.description,
                        contenu: article.contenu,
                        categorie: article.categorie,
                        auteur: article.auteur,
                        temps_lecture: article.temps_lecture,
                        statut: article.statut
                    };
                    this.showArticleModal = true;
                },
                saveArticle() {
                    if (this.editingArticle) {
                        const index = this.articles.findIndex(a => a.id === this.editingArticle.id);
                        if (index !== -1) {
                            this.articles[index] = {
                                ...this.articles[index],
                                titre: this.articleForm.titre,
                                description: this.articleForm.description,
                                contenu: this.articleForm.contenu,
                                categorie: this.articleForm.categorie,
                                auteur: this.articleForm.auteur,
                                temps_lecture: this.articleForm.temps_lecture,
                                statut: this.articleForm.statut
                            };
                        }
                    } else {
                        const newArticle = {
                            id: Math.max(...this.articles.map(a => a.id)) + 1,
                            titre: this.articleForm.titre,
                            description: this.articleForm.description,
                            contenu: this.articleForm.contenu,
                            categorie: this.articleForm.categorie,
                            auteur: this.articleForm.auteur,
                            temps_lecture: this.articleForm.temps_lecture,
                            statut: this.articleForm.statut,
                            created_at: new Date().toISOString()
                        };
                        this.articles.push(newArticle);
                    }
                    this.closeArticleModal();
                },
                openDeleteArticleModal(article) {
                    this.articleToDelete = article;
                    this.showDeleteArticleModal = true;
                },
                confirmDeleteArticle() {
                    if (this.articleToDelete) {
                        const index = this.articles.findIndex(a => a.id === this.articleToDelete.id);
                        if (index !== -1) {
                            this.articles.splice(index, 1);
                        }
                    }
                    this.closeDeleteArticleModal();
                },
                closeArticleModal() {
                    this.showArticleModal = false;
                    this.editingArticle = null;
                },
                closeDeleteArticleModal() {
                    this.showDeleteArticleModal = false;
                    this.articleToDelete = null;
                },
                openAddExerciceModal() {
                    this.editingExercice = null;
                    this.exerciceForm = {
                        titre: '',
                        description: '',
                        duree: 5,
                        statut: 'publié'
                    };
                    this.showExerciceModal = true;
                },
                editExercice(exercice) {
                    this.editingExercice = exercice;
                    this.exerciceForm = {
                        titre: exercice.titre,
                        description: exercice.description,
                        duree: exercice.duree,
                        statut: exercice.statut
                    };
                    this.showExerciceModal = true;
                },
                saveExercice() {
                    if (this.editingExercice) {
                        const index = this.exercices.findIndex(e => e.id === this.editingExercice.id);
                        if (index !== -1) {
                            this.exercices[index] = {
                                ...this.exercices[index],
                                titre: this.exerciceForm.titre,
                                description: this.exerciceForm.description,
                                duree: this.exerciceForm.duree,
                                statut: this.exerciceForm.statut
                            };
                        }
                    } else {
                        const newExercice = {
                            id: Math.max(...this.exercices.map(e => e.id)) + 1,
                            titre: this.exerciceForm.titre,
                            description: this.exerciceForm.description,
                            duree: this.exerciceForm.duree,
                            statut: this.exerciceForm.statut,
                            created_at: new Date().toISOString()
                        };
                        this.exercices.push(newExercice);
                    }
                    this.closeExerciceModal();
                },
                openDeleteExerciceModal(exercice) {
                    this.exerciceToDelete = exercice;
                    this.showDeleteExerciceModal = true;
                },
                confirmDeleteExercice() {
                    if (this.exerciceToDelete) {
                        const index = this.exercices.findIndex(e => e.id === this.exerciceToDelete.id);
                        if (index !== -1) {
                            this.exercices.splice(index, 1);
                        }
                    }
                    this.closeDeleteExerciceModal();
                },
                closeExerciceModal() {
                    this.showExerciceModal = false;
                    this.editingExercice = null;
                },
                closeDeleteExerciceModal() {
                    this.showDeleteExerciceModal = false;
                    this.exerciceToDelete = null;
                }
            }
        }).mount('#app');
    </script>
</body>
</html>
