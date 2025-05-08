<?php
class Appointments extends Controller
{
    private $appointmentModel;

    public function __construct()
    {
        $this->appointmentModel = $this->model('AppointmentModel');
    }

    public function index()
    {
        $appointments = $this->appointmentModel->getAllAppointments();
        $this->renderAdmin([
            'page_title' => 'Appointment Management',
            'view' => 'protected/appointments/index',
            'content' => [
                'appointments' => $appointments
            ]
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->appointmentModel->addAppointment($_POST);
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Appointment added successfully' : 'Failed to add appointment'
            ]);
            return;
        }

        // Get users and cars for dropdown
        $users = $this->appointmentModel->getActiveUsers();
        $cars = $this->appointmentModel->getAvailableCars();

        $this->renderAdmin([
            'page_title' => 'Add Appointment',
            'view' => 'protected/appointments/add',
            'content' => [
                'users' => $users,
                'cars' => $cars
            ]
        ]);
    }

    public function confirm($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $result = $this->appointmentModel->confirmAppointment($id);
        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Appointment confirmed successfully' : 'Failed to confirm appointment'
        ]);
    }
    public function cancel($id)
    {
         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $result = $this->appointmentModel->cancelAppointment($id);
        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Appointment cancelled successfully' : 'Failed to cancel appointment'
        ]);
    }
} 