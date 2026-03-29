<?php

namespace App\Controller\Admin;

use App\Entity\Badge;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;

class BadgeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Badge::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('label', 'Nom du Badge'),
            ColorField::new('color', 'Couleur'),
            TextField::new('icon', 'Icône du Badge')
                ->setHelp('
                    <div style="font-size: 0.9em; line-height: 1.6; margin-top: 10px;">
                        <strong>Catalogue complet :</strong> <a href="https://fontawesome.com/search?m=free" target="_blank">FontAwesome Free</a><br>
                        <strong>Sélection Top 50 :</strong><br>
                        
                        <style>
                            .badge-helper i { width: 20px; text-align: center; margin-right: 2px; color: #555; }
                            .badge-helper code { margin-right: 10px; padding: 2px 4px; border-radius: 3px; }
                        </style>

                        <div class="badge-helper">
                            <details style="margin-top: 5px;">
                                <summary style="cursor:pointer; color:#3498db;">🛡️ Sécurité & Grades</summary>
                                <ul>
                                    <li><i class="fa-solid fa-shield-halved"></i><code>fa-shield-halved</code>
                                    <li><i class="fa-solid fa-crown"></i><code>fa-crown</code></li>
                                    <li><i class="fa-solid fa-award"></i><code>fa-award</code></li>
                                    <li><i class="fa-solid fa-medal"></i><code>fa-medal</code></li>
                                    <li><i class="fa-solid fa-star"></i><code>fa-star</code></li>
                                    <li><i class="fa-solid fa-certificate"></i><code>fa-certificate</code></li>
                                    <li><i class="fa-solid fa-user-shield"></i><code>fa-user-shield</code></li>
                                    <li><i class="fa-solid fa-fingerprint"></i><code>fa-fingerprint</code></li>
                                </ul>
                            </details>
                            
                            <details>
                                <summary style="cursor:pointer; color:#e67e22;">🔥 Activité & Social</summary>
                                <ul>
                                    <li><i class="fa-solid fa-fire"></i><code>fa-fire</code></li>
                                    <li><i class="fa-solid fa-bolt"></i><code>fa-bolt</code></li>
                                    <li><i class="fa-solid fa-heart"></i><code>fa-heart</code></li>
                                    <li><i class="fa-solid fa-thumbs-up"></i><code>fa-thumbs-up</code></li>
                                    <li><i class="fa-solid fa-comments"></i><code>fa-comments</code></li>
                                    <li><i class="fa-solid fa-comment-dots"></i><code>fa-comment-dots</code></li>
                                    <li><i class="fa-solid fa-share-nodes"></i><code>fa-share-nodes</code></li>
                                    <li><i class="fa-solid fa-eye"></i><code>fa-eye</code></li>
                                    <li><i class="fa-solid fa-bullhorn"></i><code>fa-bullhorn</code></li>
                                    <li><i class="fa-solid fa-user-group"></i><code>fa-user-group</code></li>
                                </ul>
                            </details>
                            
                            <details>
                                <summary style="cursor:pointer; color:#2ecc71;">💻 Technique & Code</summary>
                                <ul>
                                    <li><i class="fa-solid fa-code"></i><code>fa-code</code></li>
                                    <li><i class="fa-solid fa-gears"></i><code>fa-gears</code></li>
                                    <li><i class="fa-solid fa-terminal"></i><code>fa-terminal</code></li>
                                    <li><i class="fa-solid fa-bug"></i><code>fa-bug</code></li>
                                    <li><i class="fa-solid fa-microchip"></i><code>fa-microchip</code></li>
                                    <li><i class="fa-solid fa-database"></i><code>fa-database</code></li>
                                    <li><i class="fa-solid fa-server"></i><code>fa-server</code></li>
                                    <li><i class="fa-solid fa-keyboard"></i><code>fa-keyboard</code></li>
                                    <li><i class="fa-solid fa-laptop-code"></i><code>fa-laptop-code</code></li>
                                    <li><i class="fa-solid fa-wrench"></i><code>fa-wrench</code></li>
                                </ul>
                            </details>
                            
                            <details>
                                <summary style="cursor:pointer; color:#9b59b6;">💡 Savoir & Idées</summary>
                                <ul>
                                    <li><i class="fa-solid fa-lightbulb"></i><code>fa-lightbulb</code></li>
                                    <li><i class="fa-solid fa-brain"></i><code>fa-brain</code></li>
                                    <li><i class="fa-solid fa-book"></i><code>fa-book</code></li>
                                    <li><i class="fa-solid fa-graduation-cap"></i><code>fa-graduation-cap</code></li>
                                    <li><i class="fa-solid fa-flask"></i><code>fa-flask</code></li>
                                    <li><i class="fa-solid fa-microscope"></i><code>fa-microscope</code></li>
                                    <li><i class="fa-solid fa-palette"></i><code>fa-palette</code></li>
                                    <li><i class="fa-solid fa-pen-nib"></i><code>fa-pen-nib</code></li>
                                    <li><i class="fa-solid fa-magnifying-glass"></i><code>fa-magnifying-glass</code></li>
                                </ul>
                            </details>
                            
                            <details>
                                <summary style="cursor:pointer; color:#e74c3c;">🚀 Divers & Fun</summary>
                                <ul>
                                    <li><i class="fa-solid fa-rocket"></i><code>fa-rocket</code></li>
                                    <li><i class="fa-solid fa-ghost"></i><code>fa-ghost</code></li>
                                    <li><i class="fa-solid fa-robot"></i><code>fa-robot</code></li>
                                    <li><i class="fa-solid fa-mug-hot"></i><code>fa-mug-hot</code></li>
                                    <li><i class="fa-solid fa-pizza-slice"></i><code>fa-pizza-slice</code></li>
                                    <li><i class="fa-solid fa-gamepad"></i><code>fa-gamepad</code></li>
                                    <li><i class="fa-solid fa-gift"></i><code>fa-gift</code></li>
                                    <li><i class="fa-solid fa-anchor"></i><code>fa-anchor</code></li>
                                    <li><i class="fa-solid fa-paper-plane"></i><code>fa-paper-plane</code></li>
                                    <li><i class="fa-solid fa-earth-europe"></i><code>fa-earth-europe</code></li>
                                </ul>
                            </details>
                        </div>
                    </div>
                ')
                ->setHtmlAttributes(['placeholder' => 'fa-star'])
                ->setRequired(false),
        ];
    }
    
}
