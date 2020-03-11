<?php

namespace App\Controller\Admin;

use App\Form\TableSettingsForm;
use App\Form\Type\TableSettingsType;
use App\Service\TableSettings;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as CoreSecurity;

/**
 * Admin controller.
 */
class TableSettingsController extends AbstractController
{
    private $request;
    private $settingsService;

    public function __construct(TableSettings $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @Route("/admin/table/settings/edit/", defaults={}, name="table.settings.edit")
     *
     * @param Request      $request
     * @param CoreSecurity $security
     *
     * @return Response
     */
    public function index(Request $request, CoreSecurity $security)
    {
        $this->setRequest($request);
        $tableSettings = new TableSettingsType();
        $settings = $this->getUser()->getSettings();
        $userTableSettings = TableSettings::getByTableCode($settings, $request->get('tableCode'));
        $settingsRequest = $request->query->all();
        unset($settingsRequest['tableCode']);
        unset($settingsRequest['backUrl']);
        $tableSettings->setTableCode($request->get('tableCode'));
        $tableSettings->setColumns(array_keys($settingsRequest));
        $tableSettings->setAllVisibility(array_keys($settingsRequest));
        $tableSettings->unsetVisibility($userTableSettings['hide']);
        $tableSettings->setLimit($userTableSettings['limit']);

        return $this->renderTableSettingsForm($tableSettings, $request, $security);
    }

    protected function renderTableSettingsForm(TableSettingsType $tableSettings, Request $request, CoreSecurity $security)
    {
        $editForm = $this->createTableSettingsForm($tableSettings, $security);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $user = $this->getUser();
            $this->settingsService->save($user, $tableSettings);

            return $this->redirectToRoute($request->get('backUrl'));
        }

        return $this->render(
            'form.html.twig',
            [
                'title' => 'Grid Settings',
                'tableSettings' => $tableSettings,
                'form' => $editForm->createView(),
            ]
        );
    }

    private function createTableSettingsForm(TableSettingsType $tableSettings, CoreSecurity $security)
    {
        $request = $this->getRequest();
        $settingsRequest = $request->query->all();
        unset($settingsRequest['tableCode']);
        unset($settingsRequest['backUrl']);
        $tableColumns = array_flip($settingsRequest);

        return $this->createForm(TableSettingsForm::class, $tableSettings, [
            'action' => $this->generateUrl('table.settings.edit', $request->query->all()),
            'method' => 'POST',
            'user' => $security->getUser(),
            'columns' => $tableColumns,
        ]);
    }
}
